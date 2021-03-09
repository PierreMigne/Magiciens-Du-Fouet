const gridContainer = document.querySelector('#virtualPassword')
const gridItems = gridContainer.childNodes
const login = document.querySelector('#inputEmail')
const password = document.querySelector('#inputPassword')
const effacer = document.querySelector('#effacer')

const values = ["0","1","2","3","4","5","6","7","8","9"," "," "," "," "," "," "]

for (let i = 0; i < values.length; i++) {
    let item = document.createElement('div');
    item.classList.add('col')
    item.innerText = values[i]
    item.setAttribute('data-grid', values[i])
    item.style.order = Math.floor(Math.random()*50)
    gridContainer.appendChild(item)
}

gridItems.forEach(item => item.addEventListener('click', () => {
    let attribut = item.getAttribute('data-grid')
    if (attribut !== " ") {
        password.value += attribut
    }
}))

effacer.addEventListener('click', ()=> {
    password.value = ""
    gridItems.forEach(element => element.style.order = Math.floor(Math.random()*50));
})


