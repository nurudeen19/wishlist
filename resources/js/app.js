/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';


const app = createApp({
  data(){
    return{
      current_list_id:'',
      current_list_name: '',
      active_list:'active_list',
      items:[],
    }
  },
  methods:{
    // set current List Name and Id
    set_current_list(id, name){
      this.current_list_id = id;
      this.current_list_name = name;
      this.get_items();
    },
    get_items(){
      axios.get('/wishlist/'+this.current_list_id)
      .then((response)=>{
            this.items = response.data.items; 
            console.log(this.items);          
          })
          .catch((error)=>{
            console.log(error.message);
      });
    }
  }
});


app.mount('#app');
