# Principais configurações de negócios e branding

Antes de criar sua primeira fatura, configurar corretamente o seu perfil comercial principal é absolutamente essencial. Este perfil determina fortemente a apresentação legal de seus documentos e como os clientes percebem visualmente sua marca.

Navegue até **Configurações > Configurações comerciais** para acessar o terminal de configuração mestre.

---

## 1. Apresentação Legal e Conformidade
Faturar não é apenas pedir dinheiro; é uma transação legal que deve cumprir rigorosamente os regulamentos fiscais da sua jurisdição.

### Informações comerciais
Certifique-se de que esses campos estejam preenchidos perfeitamente, pois aparecem permanentemente em todos os documentos PDF gerados:
- **Nome Corporativo:** A razão social completa e registrada da sua entidade (por exemplo, "Acme Corp LLC").
- **Endereço registrado:** A localização física da sede corporativa.
- **Número de Identificação Fiscal (TIN/VAT):** Este é um dos campos mais críticos da plataforma. Dependendo do seu país (por exemplo, os Estados Unidos exigem um EIN, os países europeus exigem um número de IVA), você deve inserir seu ID fiscal aqui. Depois de salva, essa string de ID é automaticamente injetada no cabeçalho legal de cada fatura que você cria, garantindo a máxima conformidade legal de forma integrada.

---

## 2. Temas e recursos visuais globais avançados
A plataforma permite que você reformule completamente não apenas os documentos de saída, mas toda a interface do software para corresponder à identidade de sua marca estabelecida.

### Fazendo upload de recursos visuais
- **Logotipo corporativo:** Faça upload de um PNG ou JPEG de alta resolução. O sistema redimensionará e posicionará automaticamente este logotipo nas suas faturas de saída e dentro do Portal do Cliente.
- **Favicon:** Carregue um pequeno arquivo `.ico` ou `.png`. Este ícone aparecerá na aba do navegador quando seus clientes fizerem login em seu portal personalizado, garantindo uma experiência totalmente branca.

### Tema algorítmico de SaaS
Se você estiver operando como administrador, poderá navegar até a guia exclusiva **Tema**.
- Aqui, você insere a cor hexadecimal primária principal da sua empresa (por exemplo, `#FF5733`).
- **O AI Color Engine:** No momento em que você salva essa cor, nossa IA a analisa profundamente. Em seguida, ele gera dinamicamente uma paleta de cores harmoniosa de 15 tons (claros e escuros perfeitamente contrastantes) e a aplica em toda a interface SaaS. Sua barra lateral, botões, barras de progresso e alertas se transformam instantaneamente para corresponder implicitamente à sua marca.

---

## 3. Integrando Stripe para saída imediata
Receber pagamento rapidamente é o objetivo final da plataforma. A integração da sua infraestrutura bancária leva trinta segundos.

- Navegue até a guia **Pagamentos** nas suas configurações globais.
- Clique em **"Conectar com Stripe."** 
- Você será direcionado com segurança para o portal de integração do Stripe. Se você já possui uma conta Stripe, o login é instantâneo. Caso contrário, você poderá criar um em três minutos.
- **The Magic Link:** Uma vez interconectadas, cada fatura que você gerar deste ponto em diante gerará programaticamente um enorme botão "Pagar agora" dentro do Portal do Cliente. Seus clientes clicam no botão, digitam o cartão de crédito em um modal altamente seguro e o dinheiro cai direto na sua conta bancária corporativa. Além disso, a plataforma sinaliza automaticamente sua fatura interna como “Paga” sem entrada manual de dados.