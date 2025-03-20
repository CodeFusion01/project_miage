const btnShowpass = document.querySelector(".show"),
  inputpass = document.querySelector(".inputpass");

  btnShowpass.addEventListener('click',()=>{
        if(inputpass.type === 'password'){
            inputpass.type = 'text';
        }else{
            inputpass.type = "password";
        }
  })