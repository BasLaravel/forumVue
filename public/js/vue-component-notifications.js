
Vue.component('notifications-dropdown', {


    props:['attribuutuserid'],
    
        data() {
            return {
                standaardmessage:true,
                showbell:'',
                data:[]
            }
        },
    
        methods: {
            getAllNotifications(){
                axios.get('/profiles/'+this.attribuutuserid+'/notifications')
                .then((response) => {
                        if(response.data.length != 0){
                            this.standaardmessage=false;
                            this.showbell=true;
                            this.data=response.data;
                            flash({message:'Uw heeft notificaties', danger:'0'});
                                }else{this.standaardmessage=true;}
                })
                .catch((error) => {
                    this.errors=error.response.data.errors; 
                });
            },
    
           markAsRead(notifications_id){
            axios.delete('/profiles/'+this.attribuutuserid+'/notifications/'+notifications_id)
            .catch((error) => {
                    this.errors=error.response.data.errors; 
                });
           
           } 
    
       },
    
       created(){
        this.getAllNotifications();
       }
    
    
    });