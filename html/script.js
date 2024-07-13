function confirmarCancelamento() {
    var confirmar = confirm("Confirmar o cancelamento da visita?");
    if (confirmar){
        $('#aguarde').removeClass('d-none');
    }
    return confirmar;
};

function confirmarRealizacao() {
    var confirmar = confirm('Confirmar a realização da visita?');
    if (confirmar){
        $('#aguarde').removeClass('d-none');
    }
    return confirmar;
}

function confirmarFinalizacao() {
    var confirmar = confirm('Confirmar a finalização desde contrato?');
    if (confirmar){
        $('#aguarde').removeClass('d-none');
    }
    return confirmar;
}

function confirmarExclusao(){
    return confirm('Confirmar a exclusão do registro?');
}