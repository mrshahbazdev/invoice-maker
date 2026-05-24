# Produtos e controle de estoque: guia completo de recursos

Redigitar constantemente as mesmas descrições de itens, preços e taxas de impostos sempre que você gera uma fatura é ineficiente e sujeito a erros. O módulo **Produtos** atua como seu catálogo central e sistema básico de gerenciamento de estoque, projetado para acelerar radicalmente seu fluxo de trabalho de faturamento.

---

## 1. Criando seu catálogo mestre
Navegue até a guia **Produtos** para começar a criar seu banco de dados de bens e serviços.

### Configuração de item padrão
Ao definir um novo produto ou serviço, você pode configurar vários padrões permanentes:
- **Nome e descrição do item:** Escreva uma descrição clara e profissional. Esse texto exato será preenchido no item de linha da fatura, garantindo que seus clientes sempre recebam explicações consistentes sobre o que estão comprando.
- **Preço unitário padrão:** Defina sua taxa padrão. Quer você cobre US$ 150/hora por consultoria ou US$ 25 por um widget físico, salvá-lo aqui significa que você nunca mais precisará consultar preços.
- **Regras tributárias:** Itens diferentes geralmente têm obrigações fiscais diferentes (por exemplo, bens físicos podem ter um imposto sobre vendas de 10%, enquanto serviços digitais podem ser isentos de impostos). Você pode atribuir uma *Taxa de imposto padrão* específica a um item. Quando você adiciona este item a uma fatura, o sistema aplica automaticamente a matemática fiscal correta sem que você levante um dedo.

---

## 2. Gerenciamento automatizado de estoque e estoque
Se sua empresa vende produtos físicos em vez de serviços abstratos, é fundamental rastrear exatamente quantos itens você ainda tem no armazém. A plataforma conta com um sistema automatizado de microinventário.

### Habilitando rastreamento de estoque
Ao criar ou editar um produto físico, basta alternar o botão **"Gerenciar estoque"** para a posição LIGADO.
- Você será solicitado a inserir sua **Quantidade atual disponível** (por exemplo, 500 unidades).
- Isso estabelece seu estoque básico para este SKU específico.

### Dedução automática em tempo real
A magia do sistema de inventário acontece durante a fase de faturamento de forma totalmente automática.
- Sempre que você finaliza e envia uma **Fatura** que contém um produto com estoque gerenciado, o sistema imediatamente lê a quantidade faturada naquela fatura e a deduz do seu banco de dados mestre.
- *Exemplo:* Se você tiver 500 widgets e enviar uma fatura cobrando de um cliente por 50 widgets, seu estoque mestre cairá automaticamente para 450.
- Isso garante que você nunca venda acidentalmente um item que não possui mais. 
- *Nota:* As estimativas não deduzem estoque, pois não são vendas finalizadas. Somente faturas ativas enviadas acionam a lógica de dedução.

---

## 3. Integração rápida de faturamento
O verdadeiro poder do módulo Produtos é percebido quando você está realmente criando uma fatura ou orçamento.

- Dentro do Invoice Builder, em vez de digitar na linha em branco, clique no menu suspenso **"Adicionar Produto"**.
- Selecione seu item pré-configurado.
- O sistema preenche instantaneamente a descrição, define o preço unitário, aplica o imposto correto e calcula o total da linha. 
- Criar uma fatura complexa de 20 itens leva apenas alguns segundos, em vez de vários minutos de entrada manual de dados.

---

## 4. Edição e ajustes de custos
Os preços evoluem ao longo do tempo com base nos custos do fornecedor ou na demanda do mercado.
- Você pode editar livremente o preço padrão de qualquer item do seu catálogo mestre a qualquer momento.
- **Integridade histórica:** Modificar o preço de um item de catálogo *não* altera faturas antigas já enviadas. Seus registros financeiros históricos permanecerão perfeitamente intactos, enquanto todas as faturas recém-geradas herdarão a lógica de preços atualizada.