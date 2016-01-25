/**
 * Created by Администратор on 10.11.2015.
 */

function isCompany(){
    $("#how_signup").text("Регистрация компании");
    $(".field-signupform-username label").text("Название компании");
    $("#fio").text("Укажите данные о компании");
    $("#lbl-text").text("как частное лицо");
    $("#s_name").show();
    $(".field-signupform-name label").text("Имя контактного лица");
}

function isPerson(){
    $("#how_signup").text("Регистрация частного лица");
    $(".field-signupform-username label").text("Ваше имя");
    $("#fio").text("Уточните пожалуйста свои данные");
    $("#lbl-text").text("как компания");
    $("#s_name").hide();
}