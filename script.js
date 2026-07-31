document.getElementById('form-matricula').addEventListener('submit', function(event) {
    event.preventDefault(); 
    
    var inputNome = document.getElementById('nome');
    var inputEmail = document.getElementById('email');
    var inputTelefone = document.getElementById('telefone'); 
    var inputCurso = document.getElementById('curso-interesse'); 

    var erroNome = document.getElementById('erro-nome');
    var erroEmail = document.getElementById('erro-email');
    var erroTelefone = document.getElementById('erro-telefone'); 
    var erroCurso = document.getElementById('erro-curso');

    var formularioValido = true;

    var apenasLetras = /^[A-Za-zÀ-ÿ\s]+$/;
    if (!apenasLetras.test(inputNome.value.trim())) {
        erroNome.style.display = 'block';
        inputNome.style.borderColor = '#ff4d4d';
        formularioValido = false;
    } else {
        erroNome.style.display = 'none';
        inputNome.style.borderColor = '#28a745';
    }

    var estruturaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!estruturaEmail.test(inputEmail.value.trim())) {
        erroEmail.style.display = 'block';
        inputEmail.style.borderColor = '#ff4d4d';
        formularioValido = false;
    } else {
        erroEmail.style.display = 'none';
        inputEmail.style.borderColor = '#28a745';
    }


    var estruturaTelefone = /^\(?[1-9]{2}\)?\s?(?:9\d{4}|\d{4})-?\d{4}$/;
    if (!estruturaTelefone.test(inputTelefone.value.trim())) {
        erroTelefone.style.display = 'block';
        inputTelefone.style.borderColor = '#ff4d4d';
        formularioValido = false;
    } else {
        erroTelefone.style.display = 'none';
        inputTelefone.style.borderColor = '#28a745';
    }

    if (inputCurso.value === "") {
        erroCurso.style.display = 'block';
        inputCurso.style.borderColor = '#ff4d4d';
        formularioValido = false;
    } else {
        erroCurso.style.display = 'none';
        inputCurso.style.borderColor = '#28a745';
    }

    if (formularioValido) {
        const formData = new FormData(this);
        fetch('processar_matricula.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(dados => {
            alert(dados.mensagem);
            if(dados.status === "sucesso") {
                this.reset();
                
                [inputNome, inputEmail, inputTelefone, inputCurso].forEach(el => el.style.borderColor = '');
            }
        })
        .catch(error => console.error('Erro ao enviar matrícula:', error));
    }
});

document.getElementById('nome').addEventListener('input', function() {
    var erroNome = document.getElementById('erro-nome');
    var apenasLetras = /^[A-Za-zÀ-ÿ\s]+$/;

    if (apenasLetras.test(this.value.trim())) {
        erroNome.style.display = 'none';
        this.style.borderColor = '#28a745';
    } else {
        erroNome.style.display = 'block';
        this.style.borderColor = '#ff4d4d';
    }
});

document.getElementById('email').addEventListener('input', function() {
    var erroEmail = document.getElementById('erro-email');
    var estruturaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (estruturaEmail.test(this.value.trim())) {
        erroEmail.style.display = 'none';
        this.style.borderColor = '#28a745';
    } else {
        erroEmail.style.display = 'block';
        this.style.borderColor = '#ff4d4d';
    }
});

document.getElementById('telefone').addEventListener('input', function() {
    var erroTelefone = document.getElementById('erro-telefone');
    var estruturaTelefone = /^\(?[1-9]{2}\)?\s?(?:9\d{4}|\d{4})-?\d{4}$/;

    if (estruturaTelefone.test(this.value.trim())) {
        erroTelefone.style.display = 'none';
        this.style.borderColor = '#28a745';
    } else {
        erroTelefone.style.display = 'block';
        this.style.borderColor = '#ff4d4d';
    }
});

document.getElementById('curso-interesse').addEventListener('change', function() {
    var erroCurso = document.getElementById('erro-curso');
    if (this.value !== "") {
        erroCurso.style.display = 'none';
        this.style.borderColor = '#28a745';
    } else {
        erroCurso.style.display = 'block';
        this.style.borderColor = '#ff4d4d';
    }
});

function aumentarFonte() {
    document.documentElement.classList.remove('diminuir');
    document.documentElement.classList.add('aumentar');
}

function diminuirFonte() {
    document.documentElement.classList.remove('aumentar');
    document.documentElement.classList.add('diminuir');
}

function alternarContraste() {
    document.body.classList.toggle('acessibilidade-contraste');
}

fetch('buscar_cursos.php')
  .then(response => {
      if (!response.ok) throw new Error('Erro na requisição PHP');
      return response.json();
  })
  .then(cursos => renderizarCartoes(cursos))
  .catch(erro => {
      console.warn('Falha no PHP, buscando do cursos.json:', erro);
      
      fetch('cursos.json')
          .then(res => res.json())
          .then(cursos => renderizarCartoes(cursos))
          .catch(e => console.error('Erro ao carregar cursos:', e));
  });

function renderizarCartoes(cursos) {
    const container = document.querySelector('.grade-cursos');
    if (!container) return;
    
    container.innerHTML = ''; 
    cursos.forEach(curso => {
        const topicosHtml = curso.topicos && curso.topicos.length > 0 
            ? curso.topicos.map(t => `<li>${t}</li>`).join('')
            : '';

        const card = `
            <article class="cartao-curso">
                <h4>${curso.titulo}</h4>
                <p>${curso.descricao}</p>
                <h5>O que você vai aprender:</h5>
                <ul>
                    ${topicosHtml}
                </ul>
            </article>
        `;

        container.innerHTML += card;
    });
}