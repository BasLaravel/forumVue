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
            updateReply(x){
                console.log(x);
                this.errors={};
                axios.patch('/replies/'+ this.attribuut.id,{body:x})
                .then((response) => {
                    console.log(response)
                    this.body=response.data;
                    this.bewerk=false;
                    flash({message:'Uw reply is geupdate', danger:'0'});
                })
                .catch((error) => {
                    console.log(error);
                    this.errors=error.response.data.errors; 
                });
            },
    
            deleteReply(){
                axios.delete('/replies/'+ this.attribuut.id)
                .then((response) => {
                    console.log(response.data);
                    this.showReply=false;
                    flash({message:'Uw reply is verwijderd', danger:'0'});
                    events.$emit('repliesAantal', {repliesAantal:response.data.axiosCount});
                   
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



    
Vue.component('textarea-scan-op-naam', {


    props:['textarea'],

    data() {
        return {
            textarea:this.textarea,
            nameArray:[],
            naam:'',
            opties:false
        }
        
    },

    methods: {
        scan(){       
            var match ='';
      
            if(match = this.textarea.match(/@..$/g)){
                 axios.get('/api/users?name='+ match[0].substring(1,3))
                .then((response) => {
                     this.nameArray=response.data;
                     this.opties=true;
                     console.log('gescand');
                }).catch((error) => {});
            }else{};
          
        },

        plukNaam(x){
            this.naam=x;
            var last = this.textarea.lastIndexOf('@');
            this.textarea=this.textarea.slice(0,last+1) + this.naam;
            this.opties=false;
        },

        update(){
            this.$emit('update', this.textarea);
        }
   }

});