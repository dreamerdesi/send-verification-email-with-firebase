


<script>

//Add signup event on firebase
btnSignUp.addEventListener('click', e => {
    let interval=null;
    let OnceVerify2=false;

    function OnceVerify(res) {
        if (!OnceVerify2) doneFunc(res);
        OnceVerify2=true;
        if (interval) clearInterval(interval);
        interval=null;
    }


    //Get email and pass
    const email = txtSignUpEmail.value;
    const pass = txtSignUpPassword.value;
    // const auth = firebase.auth();
 
    //Sign In
    const promise = auth.createUserWithEmailAndPassword(email, pass).then(
        () => {

            // send verification email to user
            auth.currentUser.sendEmailVerification().then(
                () => {
                  
                    interval = setInterval(() => {
                        auth.currentUser.reload().then(
                            () => {
                                if (auth.currentUser.emailVerified) OnceVerify(null);
                            }, error => {
                                OnceVerify(error);
                            }
                        );
                    }, 1000);
                }, error => {
                    OnceVerify(error);
                })
        }, error => {
            OnceVerify(error);
        }
    );
    txtMessageSignUp.innerHTML ="Creating account...";

    promise.catch(e => txtMessageSignUp.innerHTML ="Account exists or password is not long enough.");

});

</script>
