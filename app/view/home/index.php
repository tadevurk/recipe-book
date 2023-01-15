<form>
    <input type="text" id="ingredient" class="form-control form-control-dark" autocomplete="off" placeholder="Ingredient...">
    <div class="dropdown-menu" id="menu">

        <!-- Dropdown menu options go here -->
    </div>
</form>

<script>
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Listen for changes to the value of the form element
document.getElementById('ingredient').addEventListener('input', debounce(function() {
    // Get the value of the form element
    const ingredient = this.value;

    if (ingredient){
        fetch('http://localhost/api/ingredient', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(ingredient)
        })
            .then(result=> result.json())
            .then(items => {
                console.log(items)
                const menu = document.getElementById('menu')
                menu.innerHTML =''
                items.forEach(item =>{
                    const h2Element = document.createElement('h2')
                    h2Element.innerHTML = item.name
                    menu.appendChild(h2Element)
                })
            })
    }
}, 300));

</script>
