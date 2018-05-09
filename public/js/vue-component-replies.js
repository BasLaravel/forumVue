Vue.component('replies', {


    props:['attribuut'],
    
        data() {
            return {
            bewerk: false,
            body:this.attribuut.body,
            errors:{},
            showReply:true,
            buttontype:'',
            isLiked:this.attribuut.isFavorited,
            favoritesCount:this.attribuut.favoritesCount
            }
            
        },
    
        methods: {
            updateReply(){
                axios.patch('/replies/'+ this.attribuut.id,{body:this.body})
                .then((response) => {
                    this.bewerk=false;
                    flash({message:'Uw reply is geupdate', danger:'0'});
                })
                .catch((error) => {
                    console.log(error.response.data);
                    this.errors=error.response.data.errors; 
                });
            },
    
            deleteReply(){
                axios.delete('/replies/'+ this.attribuut.id)
                .then((response) => {
                    console.log(response);
                    this.showReply=false;
                    flash({message:'Uw reply is verwijderd', danger:'0'});
                    events.$emit('repliesAantal', {repliesAantal:response.data.testCount});
                   
                })
                .catch((error) => {
                    console.log(error.response.data);
                });
            },
             
           
        
            likeReply(){
                window.load=true;
                if(!this.isLiked){
                 axios.post('/replies/'+ this.attribuut.id + '/favorites')
                .then((response) => {
                    flash({message:'U heeft deze reply geliked', danger:'0'});
                    this.buttontype='col-md-auto ml-auto btn btn-sm bg-primary'
                    this.favoritesCount=response.data.favoritesCount;  
                    this.isLiked=true;
                })
                .catch((error) => {
                });
            }else{
                axios.delete('/replies/'+ this.attribuut.id + '/favorites')
                .then((response) => {
                    flash({message:'U heeft deze reply gedisliked', danger:'0'});
                    this.buttontype='col-md-auto ml-auto btn btn-sm bg-secondary'
                    this.favoritesCount=response.data.favoritesCount;  
                    this.isLiked=false;
                })
                .catch((error) => {
                });
            }
            }
       },
    
    
       created(){
        if(this.attribuut.isFavorited){
                    this.buttontype='col-md-auto ml-auto btn btn-sm bg-primary';
                }else{this.buttontype='col-md-auto ml-auto btn btn-sm bg-secondary'};
       }
    });