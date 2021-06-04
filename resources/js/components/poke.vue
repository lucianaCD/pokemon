<template>
    <td colspan="5" @click="clickRow()">
        <div class="columns">
            <div class="column">{{ poke.id }}</div>
            <div class="column">{{ poke.name }}</div>
            <div class="column">{{ poke.number }}</div>
            <div class="column">{{ poke.types }}</div>
            <div class="column"><figure class="photo is-96x96"><img class="is-rounded" :src="poke.photo" /></figure></div>
        </div>    
        <div class="columns column-extra" v-if="isHidden"> 
            <div class="column-extra-item"> <span class="c-extra-title">Altura:&nbsp;</span> {{poke.height}}</div>
            <div class="column-extra-item"> <span class="c-extra-title">Peso:&nbsp;</span> {{poke.weight}}</div>
            <div class="column-extra-item"> <span class="c-extra-title">Experiencia:&nbsp;</span> {{poke.experience}}</div>
        </div>
    </td>
</template>
<script>
export default {
  name: 'poke',
  data() {
    return {
      isHidden: false
    };
  },
  props: {
      poke: Object
  },
  methods: {
    clickRow(){
        this.isHidden = !this.isHidden;
    }
  },
};    
</script>
