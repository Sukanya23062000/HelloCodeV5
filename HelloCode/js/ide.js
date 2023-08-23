let editor;
const output = document.getElementById("output-container");
const monokai = "#272822";
const light = "#e8e9e8";
const solarDark = "#002b36";
const dark = "#141414";
const c = `#include<stdio.h>\nint main(){\n\tprintf("Hello Coder");\n\treturn 0;\n}`;
const cpp = `#include<iostream>\nint main(){\n\tstd::cout << "Hello Coder";\n\treturn 0;\n}`
const php = `<?php\n\techo"Hello Coder";\n?>`;
const py = `print("Hello Coder")`;
const node = `console.log("Hello Coder");`;
const java = `class HelloCode{\n\tpublic static void main(String[] args){\n\t\tSystem.out.println("Hello Coder");\n\t}\n}`

window.onload = function() {
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/c_cpp");
    editor.session.setValue(c);
    document.body.style.backgroundColor = monokai;
    output.style.color = "#fff";
    output.style.borderTop = "1px solid #fff";
}
function changeHeight(){
    var leftheight = $('.output').height();
    console.log(leftheight);
    $('.command-container').css({'height':leftheight});

}

function changeTheme(){
    let theme = $('#theme').val();
    editor.setTheme(`ace/theme/${theme}`);
    if(theme == "monokai"){
        document.body.style.backgroundColor = monokai;
        output.style.color = "#fff";
        output.style.borderTop = "1px solid #fff";
    }else if(theme == "kuroir"){
        document.body.style.backgroundColor = light;
        output.style.color = "#000";
        output.style.borderTop = "1px solid black";
    }else if(theme == "solarized_dark"){
        document.body.style.backgroundColor = solarDark;
        output.style.color = "#fff";
        output.style.borderTop = "1px solid #fff";
    }else if(theme == "twilight"){
        document.body.style.backgroundColor = dark;
        output.style.color = "#fff";
        output.style.borderTop = "1px solid #fff";
    }
}

function changeLanguage() {

    let language = $("#languages").val();

    if(language == 'c' || language == 'cpp'){
        editor.session.setMode("ace/mode/c_cpp");
        if(language == 'c'){
            editor.session.setValue(c);
        }else{
            editor.session.setValue(cpp);
        }
    }else if(language == 'php'){
        editor.session.setMode("ace/mode/php");
        editor.session.setValue(php);
    }else if(language == 'python'){
        editor.session.setMode("ace/mode/python");
        editor.session.setValue(py);
    }else if(language == 'node'){
        editor.session.setMode("ace/mode/javascript");
        editor.session.setValue(node);
    }else if(language == 'java'){
        editor.session.setMode("ace/mode/java");
        editor.session.setValue(java);
    }
}

function executeCode() {
    console.log("run");
    $.ajax({

        url: "/HelloCode/app/compiler.php",

        method: "POST",

        data: {
            language: $("#languages").val(),
            code: editor.getSession().getValue(),
            input: $("#inputs").val(),
        },

        success: function(response) {
            $(".output").text(response);
            changeHeight();
        }
    });
}

function downloadFile() {
    console.log("download");
    /*var link = document.createElement('a');
    link.href = "http://localhost/HelloCode/app/temp/fdd9a1e.c";
    link.download = "program."+$('#languages').val();
    link.click();*/
    $.ajax({

        url: "/HelloCode/app/download.php",

        method: "POST",

        data:{
            language: $("#languages").val(),
            code: editor.getSession().getValue()
        },

        success: function(response){
            console.log(response);
            var link = document.createElement('a');
            link.href = "/HelloCode/app/" + response;
            console.log(link.href);
            link.download = response.split("/")[1];
            link.click();
        }
    });
}
/*var inputBox = document.getElementById("input-command");
var command = "";
inputBox.onchange(() => {
    command = $('#input-command').val('');
})*/
function executeCode2(input = ""){
    console.log($("#input-command").val());
    $.ajax({

        url: "/HelloCode/app/execute.php",

        method: "POST",

        data:{
            command: $("#input-command").val(),
        },

        success: function(response) {
            $(".output").text(response);
            changeHeight();
        }
    })
}