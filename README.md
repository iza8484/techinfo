# projeto-TechInfo

 1. Ajustes de Validação (W3C)
 **HTML:** Removidas as barras invertidas (`/>`) de fechamento dos elementos vazios (`<input>`), adequando o código ao padrão HTML5.
 **HTML:** Corrigidos os atributos customizados do widget VLibras adicionando o prefixo obrigatório `data-` (`data-vw`, `data-vw-access-button` e `data-vw-plugin-wrapper`).
 **HTML:** Ajustada a hierarquia de títulos substituindo o título do banner principal por `<h1>` e as seções seguintes por `<h2>`, eliminando o salto incorreto de níveis de cabeçalho.
 **CSS:** Folha de estilo validada com 0 erros encontrados.

 2. Restrições Técnicas & Dificuldades
* **Desafio de Acessibilidade:** Integrar ferramentas externas (como o VLibras) mantendo o código estritamente válido pelas normas da W3C. A solução foi mapear os atributos usando os seletores de dados (`data-*`) aceitos pelo validador.
* **Hierarquia Visual vs. Semântica:** Ajustar a ordem dos cabeçalhos (`<h1>` e `<h2>`) sem quebrar a proporção visual e o design responsivo das fontes na tela, o que foi resolvido combinando a mudança de tags com o uso estratégico das classes e da função `clamp()` no CSS.

