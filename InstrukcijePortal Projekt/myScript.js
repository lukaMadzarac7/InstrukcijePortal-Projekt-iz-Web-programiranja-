
$(document).ready(function(){
    $("#MainTitle").hide();
    $("#Podnaslov").hide();
    $("#MainTitle").fadeIn(1000);
    $("#Podnaslov").fadeIn(1500);
    changeCategory("matGumb");

});


function changeCategory(id) {
    if(id=="fizGumb"){
        document.getElementById("matGumb").classList.remove('btn-primary');
        document.getElementById("matGumb").classList.add('btn-secondary');
        document.getElementById("progGumb").classList.remove('btn-primary');
        document.getElementById("progGumb").classList.add('btn-secondary');
        document.getElementById("fizGumb").classList.remove('btn-secondary');
        document.getElementById("fizGumb").classList.add('btn-primary');
        var id = "katfiz";
        document.getElementById("image1").src = "p.webp";
        document.getElementById("image2").src = "p.webp";
        document.getElementById("image3").src = "p.webp";
    }
    else if(id=="matGumb"){
        document.getElementById("fizGumb").classList.remove('btn-primary');
        document.getElementById("fizGumb").classList.add('btn-secondary');
        document.getElementById("progGumb").classList.remove('btn-primary');
        document.getElementById("progGumb").classList.add('btn-secondary');
        document.getElementById("matGumb").classList.remove('btn-secondary');
        document.getElementById("matGumb").classList.add('btn-primary'); 
        var id = "katmat";
        document.getElementById("image1").src = "math2.jpg";
        document.getElementById("image2").src = "math2.jpg";
        document.getElementById("image3").src = "math2.jpg";
    }
    else{
        document.getElementById("progGumb").classList.add('btn-primary');
        document.getElementById("progGumb").classList.remove('btn-secondary');
        document.getElementById("fizGumb").classList.remove('btn-primary');
        document.getElementById("matGumb").classList.remove('btn-primary');
        document.getElementById("fizGumb").classList.add('btn-secondary');
        document.getElementById("matGumb").classList.add('btn-secondary');
        var id = "katprog";
        document.getElementById("image1").src = "prog.jpg";
        document.getElementById("image2").src = "prog.jpg";
        document.getElementById("image3").src = "prog.jpg";
    }


    if(id != '')
    {
        $.ajax({
            url:"fetch.php",
            method:"POST",
            data: {id:id},
            dataType:"JSON",
            success:function(data)
            { 
             $('#naslov1').text(data.naslovUsuge1);
             $('#opis1').text(data.opisUsluge1);
             $('#cijena1').text(data.cijenaUsluge1);
             $('#imein1').text(data.username);
             $('#emailin1').text(data.email);
            } 
         });

         $.ajax({
            url:"fetch.php",
            method:"POST",
            data: {id:id},
            dataType:"JSON",
            success:function(data)
            { 
             $('#naslov2').text(data.naslovUsuge1);
             $('#opis2').text(data.opisUsluge1);
             $('#cijena2').text(data.cijenaUsluge1);
             $('#imein2').text(data.username);
             $('#emailin2').text(data.email);
            }         
         });

         $.ajax({
            url:"fetch.php",
            method:"POST",
            data: {id:id},
            dataType:"JSON",
            success:function(data)
            {
               
             $('#naslov3').text(data.naslovUsuge1);
             $('#opis3').text(data.opisUsluge1);
             $('#cijena3').text(data.cijenaUsluge1);
             $('#imein3').text(data.username);
             $('#emailin3').text(data.email);
            } 
         });
    }
}


function toggleText(val) {
    if(val=='b1'){
        var text = document.getElementById("demo1");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
    }
    else if(val=='b2'){
        var text = document.getElementById("demo2");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
    }
    else if(val=='b3'){
        var text = document.getElementById("demo3");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
    }
    else if(val=='b4'){
        var text = document.getElementById("demo4");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
    }
    else if(val=='b5'){
        var text = document.getElementById("demo5");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
    }
    else if(val=='b6'){
        var text = document.getElementById("demo6");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
    }
    else if(val=='b7'){
        var text = document.getElementById("demo7");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
    }
    else if(val=='b8'){
        var text = document.getElementById("demo8");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
    }
    else if(val=='b9'){
        var text = document.getElementById("demo9");
        if (text.style.display === "none") {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
}
}


