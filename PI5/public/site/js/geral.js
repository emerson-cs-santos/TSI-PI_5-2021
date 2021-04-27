function confirmar(titulo, pergunta, form)
{
    swal({
        title: titulo,
        text: pergunta,
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            enviarForm(form);
        }
        else
        {
            swal(
                {
                    title:  "Processo cancelado!",
                    text:   'Nada foi afetado!',
                    button: "OK",
                }
            )
        }
        });
}

function enviarForm(form)
{
    form.submit();
}

function apaga_filtros()
{
    if ( document.getElementById("tipo").value !== 'completo' )
    {
        document.getElementById("busca").value = '';
        document.getElementById("dataInicial").value = '';
        document.getElementById("dataFinal").value = '';
    }
}

function seta_completo_data()
{
    document.getElementById("busca").value = '';
    document.getElementById("tipo").value = 'completo';
}

function seta_completo_busca()
{
    document.getElementById("dataInicial").value = '';
    document.getElementById("dataFinal").value = '';
    document.getElementById("tipo").value = 'completo';
}

function preview_image(event)
{
    var reader = new FileReader();
    reader.onload =
        function()
        {
            var output = document.getElementById('ExibirIMG_inputfile');
            output.src = reader.result;
        }
    reader.readAsDataURL(event.target.files[0]);
}
