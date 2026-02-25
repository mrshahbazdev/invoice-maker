# O mecanismo de faturamento: um guia completo

A lógica central desta plataforma gira em torno de um mecanismo de faturamento automatizado altamente avançado, projetado para ajudá-lo a gerar faturamento profissional de forma totalmente integrada. Este guia cobre o conjunto completo de recursos disponíveis no fluxo de geração de faturas.

---

## 1. Iniciando uma nova fatura
Criar uma fatura é simples. Navegue até o módulo **Faturas** e clique em **Criar nova fatura**. 
Isso inicia o construtor de documentos interativo de arrastar e soltar.

### Metadados da fatura
Antes de adicionar itens de linha, você configurará os metadados principais que definem o documento:
- **Número da fatura:** Por padrão, o sistema incrementa automaticamente os números da sua fatura (por exemplo, INV-0001 tornando-se INV-0002). No entanto, você pode substituir manualmente o prefixo e o esquema de numeração nas configurações globais se utilizar um formato personalizado.
- **Data de Emissão:** A data em que o documento é gerado oficialmente. O padrão é hoje.
- **Data de Vencimento / Condições de Pagamento:** Defina quando você espera receber o dinheiro. Você pode selecionar datas exatas ou usar termos dinâmicos como "Líquido 15", "Líquido 30" ou "Vencimento no recebimento". O sistema calculará automaticamente a data de vencimento exata com base na data de emissão.
- **Seleção de cliente:** Selecione um cliente existente em seu CRM ou defina rapidamente um novo inline sem sair do construtor.

---

## 2. Gerenciando itens de linha
A seção de item de linha é onde você cria a fatura real. 

### Adicionando produtos e serviços
Você pode adicionar itens de linha de duas maneiras distintas:
1. **Entrada manual:** Digite descrições totalmente personalizadas, preços arbitrários e quantidades específicas diretamente em uma linha vazia. Isso é perfeito para projetos personalizados ou taxas de serviço exclusivas.
2. **Do inventário:** Clique no menu suspenso "Adicionar produto" para selecionar itens pré-salvos do seu catálogo de produtos/serviços. O sistema injetará instantaneamente a descrição predefinida, o preço unitário e as taxas de imposto padrão para esse item, economizando muito tempo.

### Matemática e impostos em tempo real
A tabela inteira está matematicamente integrada.
- À medida que você ajusta as quantidades ou os preços unitários, os totais das linhas são atualizados instantaneamente.
- **Impostos sobre itens de linha:** você pode atribuir diversas taxas de impostos (por exemplo, um IVA regional e um imposto sobre vendas secundário) a um único item de linha. O sistema calcula esses impostos de forma dinâmica e individual para cada linha.
- **Reordenação de arrastar e soltar:** Segure a alça no lado esquerdo de qualquer linha para reordenar a forma como os itens aparecem no PDF final. A matemática continua a calcular perfeitamente, independentemente da ordem.

---

## 3. Descontos e modificadores globais
Às vezes você precisa ajustar o total geral além dos itens de linha individuais.

- **Descontos globais:** Na parte inferior do construtor de faturas, você pode injetar um desconto global. Você pode escolher se esse desconto é um valor fixo literal (por exemplo, "desconto de US$ 50") ou uma porcentagem do subtotal (por exemplo, "desconto de 10%"). O total geral é atualizado dinamicamente para refletir as economias.
- **Notas e Termos:** Adicione uma mensagem personalizada ao cliente (como "Obrigado pela sua empresa!") e defina Termos e Condições Legais estritos (como "Atrasos nos pagamentos incorrem em multa de 5%).

---

## 4. Envio e entrega
Assim que sua fatura for finalizada, é hora de receber o pagamento.

### Envio automatizado de e-mail
Clicar em "Enviar fatura" abre o iniciador de e-mail.
- O sistema carrega automaticamente o endereço de e-mail principal atribuído ao seu Cliente.
- Você pode personalizar bastante a linha de assunto e o corpo HTML do e-mail. Caso você tenha definido um template específico para este cliente no CRM, ele estará pré-carregado.
- A plataforma anexa um PDF do documento altamente compactado e lindamente gerado diretamente ao e-mail enviado.

### Portal do Cliente "Magic Link"
Fundamentalmente, o e-mail também contém um “Link Mágico”. Quando o seu cliente clica neste link, ele é direcionado diretamente para o Portal do Cliente seguro e sem senha, onde pode visualizar a fatura dinamicamente.

### Rastreamento de status
Assim que uma fatura é enviada, o sistema começa a rastrear seu status automaticamente:
- Você verá exatamente quando o cliente abrir o e-mail e visualizar o documento online (o status muda de Enviado para Visualizado).
- Se a data de vencimento for aprovada, o sistema sinaliza a fatura com um emblema vermelho **Atrasado**.
- Quando os pagamentos são registrados (manualmente ou via Stripe), o saldo é atualizado. Se pago parcialmente, passa para “Parcial”. Se totalmente liquidado, será arquivado como “Pago”.