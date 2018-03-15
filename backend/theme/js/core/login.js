function validateLogin(element){
    var value = document.forms["login"]["email"].value;
    //value = testRegValue(/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/, value);
    if (value === null || value === "") {
        alert("P.f. insira username");
        return false;
    }
    value = document.forms["login"]["password"].value;
    if (value === null || value === "") {
        alert("P.f. preencha password");
        return false;
    }
}

function testRegValue(reg, value){
    return (reg.test(value) === false)? null :value;
}