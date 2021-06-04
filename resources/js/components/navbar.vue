<template>
    <nav class="navBar" role="navigation" aria-label="main navigation" >
        <div id="navbarPrincipal" class="navbar-menu" >
            <div class="navbar-start">
                <div class="navbar-item"><img src="pokemon.png" width="112" height="50"></div>
                <div class="navbar-item is-size-5"><router-link :to="{name: 'pokemons' }">Pokemons</router-link></div>             
                <div class="navbar-item is-size-5"><router-link :to="{name: 'about' }">Informaci&oacute;n</router-link></div>
            </div>
            <div class="navbar-end">
            </div>
        </div>
    </nav>    
</template>

<script>
</script>
