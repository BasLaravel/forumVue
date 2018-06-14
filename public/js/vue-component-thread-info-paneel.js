
Vue.component('show-thread', {

    props:['attribuut'],
    
    
        data() {
            return {
            bewerk:'',
            body:this.attribuut.body,
            errors:{},
            path:'/threads/'+this.attribuut.channel.slug+'/'+this.attribuut.slug,
            title:this.attribuut.title,
           
           
          
            
            }
        },
    
    methods: {

        cancel(){
            this.title=this.title;
        },
 
        updateThread(x){
            console.log(x);
            console.log(this.title);
            this.errors={};
            axios.patch(this.path,{body:x, title:this.title, channel_id:this.attribuut.channel.id})
            .then((response) => {
                console.log(response.data.title)
                this.body=response.data.body;
                this.title=response.data.title;
                this.bewerk=false;
                flash({message:'Uw thread is geupdate', danger:'0'});
            })
            .catch((error) => {
                console.log(error);
                this.errors=error.response.data.errors; 
            });
        }

    },

    created(){
      
    }
    
    
});




Vue.component('reply-form', {

    props:['attribuut'],
    
    
        data() {
            return {
            locked: this.attribuut.locked
            
            }
        },
    
    methods: {
 
    },

    created(){
        console.log(this.locked);
        events.$on('Locked', (status) => {this.locked=status;});
    }
    
    
});




Vue.component('thread-info-paneel', {

    props:['attribuutrepliesaantal', 'attribuut'],
    
    
        data() {
            return {
            repliesAantal:this.attribuutrepliesaantal,
            subscription:this.attribuut.isSubscribed,
            slug:this.attribuut.channel.slug,
            slug:this.attribuut.slug,
            locked:this.attribuut.locked
            }
        },
    
    methods: {

        toggleLock(){
          

            axios[this.locked ? 'delete':'post']('/locked-threads/'+this.slug)
            .then((response) => {
                console.log(response);     
            });
            this.locked= ! this.locked;
            events.$emit('Locked',this.locked);

        },
        
        updateCount(axiosCount){
         this.repliesAantal=axiosCount.repliesAantal;
        },


        subscribeToThread(){
            if(!this.subscription){
                axios.post('/threads/'+this.slug+'/'+this.slug+'/subscriptions')
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
                axios.delete('/threads/'+this.slug+'/'+this.slug+'/subscriptions')
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


    
 

            
