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
