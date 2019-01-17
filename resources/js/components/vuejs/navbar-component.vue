<template>
    <nav id="nav-navbar" class="relative w-full select-none bg-teal lg:flex lg:items-stretch">
        <div class="flex flex-no-shrink items-stretch h-12">
            <a href="/" class="relative flex items-center flex-no-grow flex-no-shrink py-2 px-4 leading-normal text-white no-underline hover:bg-teal-dark">Belich Dashboard</a>
            <button @click="menuToggle" class="relative block text-white hover:text-yellow cursor-pointer ml-auto w-12 h-12 p-4 lg:hidden">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                </svg>
            </button>
        </div>
        <div :class="isMobile ? 'block fade-in' : 'hidden'" class="bg-teal-dark lg:bg-teal lg:flex lg:items-stretch lg:flex-no-shrink lg:flex-grow">
            <div class="lg:flex lg:items-stretch lg:justify-end ml-auto">
                <a href="#" class="navbar-item">Item 1</a>
                <a href="#" class="navbar-item">Item 2</a>
                <a href="#" class="navbar-item">Item 3</a>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        data: function () {
            return {
                isMobile: false,
            }
        },
        methods: {
            menuToggle() {
                this.isMobile = !this.isMobile;
            },
        },
    }
</script>
