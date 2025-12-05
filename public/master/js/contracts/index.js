let fullEditor;

$(() => {
    const fullToolbar = [
        [
          {
            font: []
          },
          {
            size: []
          }
        ],
        ['bold', 'italic', 'underline', 'strike'],
        ['|'],
        [
          {
            color: []
          },
          {
            background: []
          }
        ],
        [
          {
            script: 'super'
          },
          {
            script: 'sub'
          }
        ],
        [
          {
            header: '1'
          },
          {
            header: '2'
          },
          'blockquote',
          'code-block'
        ],
        [
          {
            list: 'ordered'
          },
          {
            list: 'bullet'
          },
          {
            indent: '-1'
          },
          {
            indent: '+1'
          }
        ],
        [{ align: [] }],
        [{ direction: 'rtl' }],
        ['link', 'image', 'formula'],
        ['clean']
      ];
       fullEditor = new Quill('#full-editor', {
        bounds: '#full-editor',
        placeholder: 'Contrato...',
        modules: {
          formula: true,
          toolbar: fullToolbar
        },
        theme: 'snow'
      });
})

async function sendContract(e){
    e.preventDefault();

    const {isValid, data} = validData("form-contract");

    if(!isValid){
        alert('Campos obligatorios', 'Por favor llenar los campos requeridos.', 'warning', 5000);
        return false;
    }

    const description = fullEditor.root.innerHTML;
    data.description = description;

    const url = base_url(['dashboard/contract/save']);

    const res = await fetchHelper.post(url, data);

    if(data.contrato == "")
        $('#contrato').val(res.data.contrato);

    console.log([isValid, data, res.data])

}