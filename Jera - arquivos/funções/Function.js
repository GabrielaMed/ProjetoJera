

function showHideRow(row) {
    $('#' + row).toggle();
}


function abrirAviso(modal_name){
    
    let modal = document.querySelector(modal_name);
    
    if (typeof modal == 'undefined' || modal == null)
    return;
    modal.style.display = 'flex';
    modal.style.justifyContent  = 'center';
    modal.style.alignItems = 'center';
    document.body.style.overflow = 'hidden';
    
}
function abrirAvisoUnico(modal_name){
    
    let modal = document.querySelector(modal_name);
    let modalLoguia = document.querySelector('.modal_atualizar_estoque');
    
    if ((typeof modal == 'undefined' || modal == null) && (typeof modalLoguia == 'undefined' || modalLoguia == null))
    return;
    modalLoguia.display = 'none';
    modal.style.display = 'flex';
    modal.style.justifyContent  = 'center';
    modal.style.alignItems = 'center';
    document.body.style.overflow = 'hidden';
    
}

function mask(e, id, mask){
    var tecla=(window.event)?event.keyCode:e.which;   
    if(tecla>47 && tecla<58){
        mascara(id, mask);
        return true;
    } 
    else{
        if (tecla==8 || tecla==0){
            mascara(id, mask);
            return true;
        } 
        else  return false;
    }
}


function mascara(id, mask){
    var i = id.value.length;
    var carac = mask.substring(i, i+1);
    var prox_char = mask.substring(i+1, i+2);
    if(i == 0 && carac != '#'){
        insereCaracter(id, carac);
        if(prox_char != '#')insereCaracter(id, prox_char);
    }
    else if(carac != '#'){
        insereCaracter(id, carac);
        if(prox_char != '#')insereCaracter(id, prox_char);
    }
    function insereCaracter(id, char){
        id.value += char;
    }
}


// change dropdown placeholder
$(".dropdown-menu li").click(function(){
    $(this).parents(".dropdown").find('.nivelUsuario').text($(this).text());
});
//pass li value with user_level
$(function(){
    $(".dropdown-menu li").click(function(){
        var value = $(this).attr("value");
        $("input[name='valueDropdown']").val(value);
    })
})

function searchTableColumns() {
    var input, filter, table, tr, i, j, column_length, count_td,oculta;
    column_length = document.querySelector("table").rows[0].cells.length;
    input = document.getElementById("input-pesq");
    filter = input.value.toUpperCase();
    table = document.querySelector("table");
    tr = table.getElementsByClassName("parentRow");
    oculta = document.getElementsByClassName("subRow");
    for (i = 0; i < tr.length; i++) { // except first(heading) row
        count_td = 0;
        for(j = 0; j < column_length+1; j++){ // except first column
            td = tr[i].getElementsByTagName("td")[j];
            /* ADD columns here that you want you to filter to be used on */
            if (td) {
                if ( td.innerHTML.toUpperCase().indexOf(filter) >= 0)  {            
                    count_td++;                  
                }
            }
        }
        if(count_td > 0){
            tr[i].style.display = "";
        } 
        else {
            tr[i].style.display = "none";
            oculta[i].style.display = "none";
        }
    }
}
    
function search(pesquisa) {
    let input = document.getElementById('input-pesq').value
    input = input.toLowerCase();
    let x = document.getElementsByClassName(pesquisa);
    
    for (i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display="none";
        }
        else {
            x[i].style.display="";                
        }
    }
}
function PesquisaCheckBox(box,pesquisa){
    let check = document.getElementById(box);
    let x = document.getElementsByClassName(pesquisa);

    for (let i = 0; i < x.length; i++) {
        if(check.checked){
            x[i].style = "";
        }    
        else{
            x[i].style.display="none";
        }
    }
}

function SemCaracterEspecial(pTexto){
    $(pTexto).on('keypress', function() {
        var regex = new RegExp("^[_a-zA-Z0-9-Zàèìòùáéíóúâêîôûãõç\b ]+$");
        var _this = this;
        // Curta pausa para esperar colar para completar
        setTimeout( function(){
            var texto = $(_this).val();
            if(!regex.test(texto))
            {
                $(_this).val(texto.substring(0, (texto.length-1)))
            }
        }, 100);
    });
}
