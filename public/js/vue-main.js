//--------------------------axios interceptors-----------------------
// Add a request interceptor
axios.interceptors.request.use((config) => {
    window.load=true;
    config.timeout=5000;
    return config;
  }, (error) => {
    flash({message:'Fout op de server', danger:'1'});
    return Promise.reject(error);
  });

  // Add a response interceptor
axios.interceptors.response.use((response) => { 
    window.load=false;
   
    return response;
  },(error) => {
    if(error.response.status > '499'){
                    flash({message:'Fout op de server', danger:'1'});
                    }
    window.load=false;
    return Promise.reject(error);
  });


//-------------------------------------Vue-instance-----------------------------------------------


new Vue({
    el:'#app',

    

    data:{
        flashVue: false,
        tekst:'',
        status:'alert alert-info',
  },


 methods:{
     flash(tekst){
         if(tekst.danger=='0'){
            this.status='alert alert-info';
         }else{ 
             this.status='alert alert-danger';
         };

         this.flashVue=true;
         this.tekst=tekst.message;
         setTimeout(()=>{ this.flashVue = false; }, 2000);
         
     }

 

},

created(){
    window.events.$on('flash',this.flash);
}




});