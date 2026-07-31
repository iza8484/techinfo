<?php
header('Content-Type: application/json; charset=utf-8');

$host    = '127.0.0.1';
$usuario = 'root';
$senha   = '';
$banco   = 'techinfo_db';
$porta   = 3306; 

$conexao = @new mysqli($host, $usuario, $senha, $banco, $porta);

$lista_aprendizado = [
    "Técnico em Informática" => ["Arquitetura de Computadores", "Redes de Computadores", "Lógica de Programação"],
    "informatica"            => ["Arquitetura de Computadores", "Redes de Computadores", "Lógica de Programação"],
    
    "Desenvolvimento Web"    => ["HTML5 e CSS3 Semântico", "JavaScript e jQuery", "Padrões W3C e Responsividade"],
    "web"                    => ["HTML5 e CSS3 Semântico", "JavaScript e jQuery", "Padrões W3C e Responsividade"],
    
    "Banco de Dados"         => ["Modelagem Relacional", "Linguagem SQL", "Administração de Banco de Dados"],
    "banco-dados"            => ["Modelagem Relacional", "Linguagem SQL", "Administração de Banco de Dados"]
];

if ($conexao->connect_error) {
    $cursos_padrao = [
        [
            "titulo" => "Técnico em Informática",
            "descricao" => "Aprenda a planejar e executar os processos de manutenção, redes e a lógica de programação.",
            "topicos" => $lista_aprendizado["Técnico em Informática"]
        ],
        [
            "titulo" => "Desenvolvimento Web",
            "descricao" => "Domine as tecnologias mais modernas do mercado para criar sites e aplicativos incríveis.",
            "topicos" => $lista_aprendizado["Desenvolvimento Web"]
        ],
        [
            "titulo" => "Banco de Dados",
            "descricao" => "Aprenda a modelar, gerenciar e otimizar bancos de dados relacionais e segurança da informação.",
            "topicos" => $lista_aprendizado["Banco de Dados"]
        ]
    ];
    echo json_encode($cursos_padrao);
    exit;
}

$resultado = $conexao->query("SELECT titulo, descricao FROM cursos");

$cursos = array();
if ($resultado && $resultado->num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
        $titulo = $row['titulo'];
        $row['topicos'] = isset($lista_aprendizado[$titulo]) ? $lista_aprendizado[$titulo] : array();
        $cursos[] = $row;
    }
} else {
    // Caso a tabela 'cursos' no banco esteja vazia
    $cursos = [
        [
            "titulo" => "Técnico em Informática",
            "descricao" => "Aprenda a planejar e executar os processos de manutenção, redes e a lógica de programação.",
            "topicos" => $lista_aprendizado["Técnico em Informática"]
        ],
        [
            "titulo" => "Desenvolvimento Web",
            "descricao" => "Domine as tecnologias mais modernas do mercado para criar sites e aplicativos incríveis.",
            "topicos" => $lista_aprendizado["Desenvolvimento Web"]
        ],
        [
            "titulo" => "Banco de Dados",
            "descricao" => "Aprenda a modelar, gerenciar e otimizar bancos de dados relacionais e segurança da informação.",
            "topicos" => $lista_aprendizado["Banco de Dados"]
        ]
    ];
}

echo json_encode($cursos);
$conexao->close();
?>