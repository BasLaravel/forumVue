Vue.component('thread-info-paneel', {

    props:['attribuutrepliesaantal', 'attribuut'],
    
    
        data() {
            return {
            repliesAantal:this.attribuutrepliesaantal,
            subscription:this.attribuut.isSubscribed,
            slug:this.attribuut.channel.slug,
            id:this.attribuut.id
            }
        },
    
    methods: {
        
        updateCount(r_Aantal){
         this.repliesAantal=r_Aantal.repliesAantal;
        },


        subscribeToThread(){
            if(!this.subscription){
                axios.post('/threads/'+this.slug+'/'+this.id+'/subscriptions')
               .then((response) => {
                   flash({message:'U volgt nu deze thread', danger:'0'});
                   this.subscription=true;
               })
               .catch((error) => {
                   if(error.response.status > '499'){
                   flash({message:'Fout op de server', danger:'1'});
                   } 
               
               });
            }else{
                axios.delete('/threads/'+this.slug+'/'+this.id+'/subscriptions')
                .then((response) => {
                    flash({message:'U volgt nu deze thread niet meer', danger:'0'});
                    this.subscription=false;
                })
                .catch((error) => {
                    if(error.response.status > '499'){
                    flash({message:'Fout op de server', danger:'1'});
                    } 
                });

            }
        }
    
    },
    
    
    created(){
        events.$on('repliesAantal',this.updateCount);
    }
    
    
});


    
 

            