import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])


const searchbar = document.querySelector('#searchbar-projects');
searchbar.addEventListener('click',function(){

    alert('test')

});
