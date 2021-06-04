<template>
    <div class="container">
        <table class="table is-hoverable">     
        <thead>
            <tr class="columns">
                <th class="column is-size-5">Id</th>
                <th class="column is-size-5" >Nombre</th>
                <th class="column is-size-5" >N&uacute;mero</th>
                <th class="column is-size-5" >Tipos</th>
                <th class="column is-size-5" >Imagen</th>
            </tr>
        </thead>
        <input class="filter" type="text" v-model="selectedName" placeholder="Filtrar por nombre"/>
        <tbody>
            <tr v-for="poke in filterByName" :key="poke.id">
                <poke v-bind:poke="poke"/>
            </tr>
            <div class="notification is-size-4" v-show="message">{{ message }}</div>
            <div class="error-notification is-size-4" v-show="errorMessage">{{ errorMessage }}</div>
            <div class="page">
                <pagination  :data="pokemons" @pagination-change-page="fillPokemons">
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </div>
        </tbody>
        </table>
    </div>    
</template>

<script>
import * as axios from 'axios';
import pagination from 'laravel-vue-pagination';
import poke from './poke'

export default {
  name: 'pokemons',
  components:{
      pagination,
      poke
  },
  data() {
    return {
      apiURL: process.env.MIX_API_URL,
      selectedName: '',
      pokemons: {},
      message: '',
      errorMessage: '',
      isHidden: false
    };
  },
  mounted() {
    let page = 1;
    this.fillPokemons(page);
  },
  computed: {
    filterByName: function(){
      var name = this.selectedName;
      if(name === ''){
          return this.pokemons.data;
      }else{
          return this.pokemons.data.filter(poke => !poke.name.toLowerCase().indexOf(name.toLowerCase()));
      }
    }
  },
  methods: {
    async fillPokemons(page) {
        this.message = 'obteniendo Pokemons... espere por favor!';
        await axios.get(this.apiURL+'/api/pokemons-by-page/'+page)
            .then(response => {
                    this.pokemons = response.data;
            }).catch( err => {
                this.message = '';
                this.errorMessage = 'hubo un error obteniendo los pokemons, intentelo nuevamente más tarde!';
                setTimeout(()=> { 
                    this.errorMessage = '';
                }, 2000);
            });
        this.message = '';
    },
  },
};
</script>