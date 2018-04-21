let button = document.querySelector('.button-buy');
let form = document.querySelector('.form-show');
let close = document.querySelector('.button-close');
let message = document.querySelector('.message');
console.log(button);
const trigger = () =>{
    form.classList.toggle('form-hide');
    message.innerText = '';
};
button.addEventListener('click',trigger);
close.addEventListener('click',trigger);
form.addEventListener('submit',(e) =>{
    e.preventDefault();
    let token = document.querySelector("input[name='_token']").value;
    let data = new FormData(form);
    data.append('_token',token);
    console.log('click');
    let myHeaders = new Headers();
    myHeaders.append('X-CSRF-TOKEN',token);
    let myInit = { method: 'POST',
        body: data,
        headers: myHeaders,
    };
    fetch('/orders/register',myInit).then((response)=>{
       response.json().then((data) =>
        {
            message.innerText = data.message;
        })
    })
});