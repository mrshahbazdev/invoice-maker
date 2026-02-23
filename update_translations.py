import json
import os

keys_data = {
    "Accountant-Grade": {
        "ar": "درجة المحاسبة",
        "en": "Accountant-Grade",
        "es": "Nivel contable",
        "fr": "Niveau comptable",
        "it": "Livello contabile",
        "ja": "会計士グレード",
        "pt": "Nível contábil",
        "ru": "Уровень бухгалтера",
        "zh": "会计师级"
    },
    "Advanced Analytics": {
        "ar": "تحليلات متقدمة",
        "en": "Advanced Analytics",
        "es": "Analítica avanzada",
        "fr": "Analytique avancée",
        "it": "Analisi avanzata",
        "ja": "高度な分析",
        "pt": "Análise avançada",
        "ru": "Продвинутая аналитика",
        "zh": "高级分析"
    },
    "Allgemeines": {
        "ar": "عام",
        "en": "General",
        "es": "General",
        "fr": "Général",
        "it": "Generale",
        "ja": "全般",
        "pt": "Geral",
        "ru": "Общие",
        "zh": "常规"
    },
    "Analyze which customers and products drive your growth.": {
        "ar": "حلل أي العملاء والمنتجات يقودون نموك.",
        "en": "Analyze which customers and products drive your growth.",
        "es": "Analice qué clientes y productos impulsan su crecimiento.",
        "fr": "Analysez quels clients et produits stimulent votre croissance.",
        "it": "Analizza quali clienti e prodotti trainano la tua crescita.",
        "ja": "どの顧客や製品が成長を牽引しているかを分析します。",
        "pt": "Analise quais clientes e produtos impulsionam seu crescimento.",
        "ru": "Анализируйте, какие клиенты и продукты способствуют вашему росту.",
        "zh": "分析哪些客户和产品推动了您的增长。"
    },
    "Automated Records": {
        "ar": "سجلات آلية",
        "en": "Automated Records",
        "es": "Registros automatizados",
        "fr": "Enregistrements automatisés",
        "it": "Record automatizzati",
        "ja": "自動記録",
        "pt": "Registros automatizados",
        "ru": "Автоматизированные записи",
        "zh": "自动记录"
    },
    "Bezahlt": {
        "ar": "مدفوع",
        "en": "Paid",
        "es": "Pagado",
        "fr": "Payé",
        "it": "Pagato",
        "ja": "支払い済み",
        "pt": "Pago",
        "ru": "Оплачено",
        "zh": "已支付"
    },
    "Cash Book Ledger": {
        "ar": "دفتر الصندوق",
        "en": "Cash Book Ledger",
        "es": "Libro de caja",
        "fr": "Livre de caisse",
        "it": "Libro di cassa",
        "ja": "現金出納帳レジャー",
        "pt": "Livro de caixa",
        "ru": "Кассовая книга",
        "zh": "现金日记账总账"
    },
    "Client ROI": {
        "ar": "عائد استثمار العميل",
        "en": "Client ROI",
        "es": "ROI del cliente",
        "fr": "ROI client",
        "it": "ROI del cliente",
        "ja": "顧客ROI",
        "pt": "ROI do cliente",
        "ru": "ROI клиента",
        "zh": "客户ROI"
    },
    "Create Your Account Free": {
        "ar": "أنشئ حسابك مجانًا",
        "en": "Create Your Account Free",
        "es": "Cree su cuenta gratis",
        "fr": "Créez votre compte gratuitement",
        "it": "Crea il tuo account gratuitamente",
        "ja": "無料でアカウント作成",
        "pt": "Crie sua conta gratuitamente",
        "ru": "Создайте аккаунт бесплатно",
        "zh": "免费创建您的账户"
    },
    "Custom Integration": {
        "ar": "تكامل مخصص",
        "en": "Custom Integration",
        "es": "Integración personalizada",
        "fr": "Intégration personnalisée",
        "it": "Integrazione personalizzata",
        "ja": "カスタム統合",
        "pt": "Integração personalizada",
        "ru": "Пользовательская интеграция",
        "zh": "自定义集成"
    },
    "DEBIT": {
        "ar": "مدين",
        "en": "DEBIT",
        "es": "DÉBITO",
        "fr": "DÉBIT",
        "it": "DEBITO",
        "ja": "デビット",
        "pt": "DÉBITO",
        "ru": "ДЕБЕТ",
        "zh": "借方"
    },
    "Dedicated Manager": {
        "ar": "مدير مخصص",
        "en": "Dedicated Manager",
        "es": "Gerente dedicado",
        "fr": "Gestionnaire dédié",
        "it": "Manager dedicato",
        "ja": "専任マネージャー",
        "pt": "Gerente dedicado",
        "ru": "Выделенный менеджер",
        "zh": "专属经理"
    },
    "Einnahmen": {
        "ar": "إيرادات",
        "en": "Income",
        "es": "Ingresos",
        "fr": "Revenus",
        "it": "Entrate",
        "ja": "収益",
        "pt": "Receitas",
        "ru": "Доходы",
        "zh": "收入"
    },
    "Explore Features": {
        "ar": "استكشف الميزات",
        "en": "Explore Features",
        "es": "Explorar funciones",
        "fr": "Explorer les fonctionnalités",
        "it": "Esplora le funzionalità",
        "ja": "機能を見る",
        "pt": "Explorar recursos",
        "ru": "Изучить возможности",
        "zh": "浏览功能"
    },
    "Go to Dashboard": {
        "ar": "اذهب إلى لوحة التحكم",
        "en": "Go to Dashboard",
        "es": "Ir al tablero",
        "fr": "Aller au tableau de bord",
        "it": "Vai alla dashboard",
        "ja": "ダッシュボードへ",
        "pt": "Ir para o painel",
        "ru": "Перейти в панель управления",
        "zh": "前往仪表板"
    },
    "Income & Expense in one view.": {
        "ar": "الدخل والمصروفات في عرض واحد.",
        "en": "Income & Expense in one view.",
        "es": "Ingresos y gastos en una sola vista.",
        "fr": "Revenus et dépenses en une seule vue.",
        "it": "Entrate e uscite in un'unica vista.",
        "ja": "収入と支出を一つの画面で。",
        "pt": "Receitas e despesas em uma única visualização.",
        "ru": "Доходы и расходы в одном представлении.",
        "zh": "一目了然收支情况。"
    },
    "InvoiceMaker V2 Dashboard": {
        "ar": "لوحة تحكم InvoiceMaker V2",
        "en": "InvoiceMaker V2 Dashboard",
        "es": "Tablero de InvoiceMaker V2",
        "fr": "Tableau de bord InvoiceMaker V2",
        "it": "Dashboard InvoiceMaker V2",
        "ja": "InvoiceMaker V2 ダッシュボード",
        "pt": "Painel do InvoiceMaker V2",
        "ru": "Панель управления InvoiceMaker V2",
        "zh": "InvoiceMaker V2 仪表板"
    },
    "Invoicing": {
        "ar": "الفواتير",
        "en": "Invoicing",
        "es": "Facturación",
        "fr": "Facturation",
        "it": "Fatturazione",
        "ja": "請求業務",
        "pt": "Faturamento",
        "ru": "Выставление счетов",
        "zh": "开票"
    },
    "No credit card required": {
        "ar": "لا يتطلب بطاقة ائتمان",
        "en": "No credit card required",
        "es": "No se requiere tarjeta de crédito",
        "fr": "Aucune carte de crédit requise",
        "it": "Nessuna carta di credito richiesta",
        "ja": "クレジットカード不要",
        "pt": "Nenhum cartão de crédito necessário",
        "ru": "Кредитная карта не требуется",
        "zh": "无需信用卡"
    },
    "No more messy spreadsheets. Our professional Cash Book Ledger system automatically tracks every transaction with double-entry precision. Built for speed, accuracy, and accountants.": {
        "ar": "لا مزيد من جداول البيانات الفوضوية. يتتبع نظام دفتر الصندوق الاحترافي لدينا كل معاملة تلقائيًا بدقة القيد المزدوج. مبني للسرعة والدقة والمحاسبين.",
        "en": "No more messy spreadsheets. Our professional Cash Book Ledger system automatically tracks every transaction with double-entry precision. Built for speed, accuracy, and accountants.",
        "es": "No más hojas de cálculo desordenadas. Nuestro sistema profesional de libro de caja rastrea automáticamente cada transacción con precisión de partida doble. Construido para velocidad, precisión y contadores.",
        "fr": "Fini les feuilles de calcul en désordre. Notre système professionnel de livre de caisse suit automatiquement chaque transaction avec une précision en partie double. Conçu pour la vitesse, la précision et les comptables.",
        "it": "Niente più fogli di calcolo disordinati. Il nostro sistema professionale di libro di cassa traccia automaticamente ogni transazione con precisione a partita doppia. Costruito per velocità, accuratezza e contabili.",
        "ja": "もう乱雑なスプレッドシートはいりません。当社のプロフェッショナルな現金出納帳システムは、複式簿記の精度ですべての取引を自動的に追跡します。スピード、正確性、そして会計士のために構築されました。",
        "pt": "Chega de planilhas bagunçadas. Nosso sistema profissional de Livro de Caixa rastreia automaticamente cada transação com precisão de partidas dobradas. Construído para velocidade, precisão e contadores.",
        "ru": "Больше никаких запутанных таблиц. Наша профессиональная система кассовой книги автоматически отслеживает каждую транзакцию с точностью двойной записи. Создано для скорости, точности и бухгалтеров.",
        "zh": "告别凌乱的电子表格。我们的专业现金日记账系统通过复式记账的精确性自动跟踪每笔交易。专为速度、准确性和会计师打造。"
    },
    "OFFICE EQUIP.": {
        "ar": "معدات مكتبية",
        "en": "OFFICE EQUIP.",
        "es": "EQ. DE OFICINA",
        "fr": "ÉQUIP. DE BUREAU",
        "it": "ATTREZZ. UFFICIO",
        "ja": "事務機器",
        "pt": "EQUIP. DE ESCRITÓRIO",
        "ru": "ОФИСНОЕ ОБОРУД.",
        "zh": "办公设备"
    },
    "Perfected.": {
        "ar": "متقن.",
        "en": "Perfected.",
        "es": "Perfeccionado.",
        "fr": "Perfectionné.",
        "it": "Perfezionato.",
        "ja": "完成形。",
        "pt": "Aperfeiçoado.",
        "ru": "Доведено до совершенства.",
        "zh": "臻于完美。"
    },
    "Priority Support": {
        "ar": "دعم ذو أولوية",
        "en": "Priority Support",
        "es": "Soporte prioritario",
        "fr": "Support prioritaire",
        "it": "Supporto prioritario",
        "ja": "優先サポート",
        "pt": "Suporte prioritário",
        "ru": "Приоритетная поддержка",
        "zh": "优先支持"
    },
    "Product Margins": {
        "ar": "هوامش المنتج",
        "en": "Product Margins",
        "es": "Márgenes de producto",
        "fr": "Marges sur les produits",
        "it": "Margini del prodotto",
        "ja": "製品マージン",
        "pt": "Margens de produtos",
        "ru": "Маржа по продуктам",
        "zh": "产品利润"
    },
    "Professional Invoicing for Everyone": {
        "ar": "فواتير احترافية للجميع",
        "en": "Professional Invoicing for Everyone",
        "es": "Facturación profesional para todos",
        "fr": "Facturation professionnelle pour tous",
        "it": "Fatturazione professionale per tutti",
        "ja": "すべての人にプロフェッショナルな請求業務を",
        "pt": "Faturamento profissional para todos",
        "ru": "Профессиональные счета для каждого",
        "zh": "为每个人提供专业的开票服务"
    },
    "Profitability": {
        "ar": "الربحية",
        "en": "Profitability",
        "es": "Rentabilidad",
        "fr": "Rentabilité",
        "it": "Redditività",
        "ja": "収益性",
        "pt": "Rentabilidade",
        "ru": "Рентабельность",
        "zh": "盈利能力"
    },
    "Profitability Report": {
        "ar": "تقرير الربحية",
        "en": "Profitability Report",
        "es": "Informe de rentabilidad",
        "fr": "Rapport de rentabilité",
        "it": "Rapporto sulla redditività",
        "ja": "収益性レポート",
        "pt": "Relatório de rentabilidade",
        "ru": "Отчет о рентабельности",
        "zh": "盈利能力报告"
    },
    "RE-2024-001": {
        "ar": "RE-2024-001",
        "en": "RE-2024-001",
        "es": "RE-2024-001",
        "fr": "RE-2024-001",
        "it": "RE-2024-001",
        "ja": "RE-2024-001",
        "pt": "RE-2024-001",
        "ru": "RE-2024-001",
        "zh": "RE-2024-001"
    },
    "RECORD": {
        "ar": "سجل",
        "en": "RECORD",
        "es": "REGISTRO",
        "fr": "ENREGISTREMENT",
        "it": "REGISTRAZIONE",
        "ja": "記録",
        "pt": "REGISTRO",
        "ru": "ЗАПИСЬ",
        "zh": "记录"
    },
    "Ready to simplify your": {
        "ar": "هل أنت مستعد لتبسيط",
        "en": "Ready to simplify your",
        "es": "Listo para simplificar su",
        "fr": "Prêt à simplifier votre",
        "it": "Pronto a semplificare il tuo",
        "ja": "あなたの管理をシンプルにする準備はいいですか？",
        "pt": "Pronto para simplificar seu",
        "ru": "Готовы упростить вашу",
        "zh": "准备好简化您的"
    },
    "Real-time job margin analysis.": {
        "ar": "تحليل هامش العمل في الوقت الفعلي.",
        "en": "Real-time job margin analysis.",
        "es": "Análisis de margen de trabajo en tiempo real.",
        "fr": "Analyse de la marge de travail en temps réel.",
        "it": "Analisi del margine di lavoro in tempo reale.",
        "ja": "リアルタイムの業務マージン分析。",
        "pt": "Análise de margem de trabalho em tempo real.",
        "ru": "Анализ маржи работы в реальном времени.",
        "zh": "实时项目利润率分析。"
    },
    "Rev:": {
        "ar": "إيراد:",
        "en": "Rev:",
        "es": "Ingreso:",
        "fr": "Rev :",
        "it": "Entrate:",
        "pt": "Receita:",
        "ja": "収益:",
        "ru": "Доход:",
        "zh": "收入:"
    },
    "Revenue vs Direct Costs": {
        "ar": "الإيرادات مقابل التكاليف المباشرة",
        "en": "Revenue vs Direct Costs",
        "es": "Ingresos vs Gastos directos",
        "fr": "Revenus vs Coûts directs",
        "it": "Entrate rispetto ai costi diretti",
        "ja": "収益対直接コスト",
        "pt": "Receita vs Custos diretos",
        "ru": "Доходы против прямых затрат",
        "zh": "收入 vs 直接成本"
    },
    "Sales vs Purchase Cost": {
        "ar": "المبيعات مقابل تكلفة الشراء",
        "en": "Sales vs Purchase Cost",
        "es": "Ventas vs Costo de compra",
        "fr": "Ventes vs Coût d'achat",
        "it": "Vendite rispetto al costo d'acquisto",
        "ja": "売上対仕入コスト",
        "pt": "Vendas vs Custo de compra",
        "ru": "Продажи против себестоимости закупок",
        "zh": "销售 vs 采购成本"
    },
    "Smart Profitability": {
        "ar": "ربحية ذكية",
        "en": "Smart Profitability",
        "es": "Rentabilidad inteligente",
        "fr": "Rentabilité intelligente",
        "it": "Redditività intelligente",
        "ja": "スマートな収益性管理",
        "pt": "Rentabilidade inteligente",
        "ru": "Умная рентабельность",
        "zh": "智能盈利分析"
    },
    "Start Free Trial": {
        "ar": "ابدأ التجربة المجانية",
        "en": "Start Free Trial",
        "es": "Iniciar prueba gratuita",
        "fr": "Démarrer l'essai gratuit",
        "it": "Inizia la prova gratuita",
        "ja": "無料トライアルを開始",
        "pt": "Iniciar teste gratuito",
        "ru": "Начать бесплатный период",
        "zh": "开始免费试用"
    },
    "The ultimate invoicing solution for freelancers and small businesses worldwide.": {
        "ar": "حل الفواتير النهائي للمستقلين والشركات الصغيرة في جميع أنحاء العالم.",
        "en": "The ultimate invoicing solution for freelancers and small businesses worldwide.",
        "es": "La solución de facturación definitiva para autónomos y pequeñas empresas de todo el mundo.",
        "fr": "La solution de facturation ultime pour les pigistes et les petites entreprises du monde entier.",
        "it": "La soluzione di fatturazione definitiva per freelance e piccole imprese in tutto il mondo.",
        "ja": "世界中のフリーランサーや中小企業のための究極の請求書ソリューション。",
        "pt": "A solução de faturamento definitiva para freelancers e pequenas empresas em todo o mundo.",
        "ru": "Лучшее решение для выставления счетов для фрилансеров и малого бизнеса по всему миру.",
        "zh": "适用于全球自由职业者和小型企业的终极开票解决方案。"
    },
    "The ultimate invoicing solution for freelancers and small businesses worldwide. Create, send, and track invoices in minutes.": {
        "ar": "حل الفواتير النهائي للمستقلين والشركات الصغيرة في جميع أنحاء العالم. أنشئ وأرسل وتتبع الفواتير في دقائق.",
        "en": "The ultimate invoicing solution for freelancers and small businesses worldwide. Create, send, and track invoices in minutes.",
        "es": "La solución de facturación definitiva para autónomos y pequeñas empresas de todo el mundo. Cree, envíe y rastree facturas en minutos.",
        "fr": "La solution de facturation ultime pour les pigistes et les petites entreprises du monde entier. Créez, envoyez et suivez des factures en quelques minutes.",
        "it": "La soluzione di fatturazione definitiva per freelance e piccole imprese in tutto il mondo. Crea, invia e traccia le fatture in pochi minuti.",
        "ja": "世界中のフリーランサーや中小企業のための究極の請求書ソリューション。数分で請求書の作成、送信、追跡が可能です。",
        "pt": "A solução de faturamento definitiva para freelancers e pequenas empresas em todo o mundo. Crie, envie e acompanhe faturas em minutos.",
        "ru": "Лучшее решение для выставления счетов для фрилансеров и малого бизнеса по всему миру. Создавайте, отправляйте и отслеживайте счета за считанные минуты.",
        "zh": "适用于全球自由职业者和小型企业的终极开票解决方案。几分钟内即可创建、发送和跟踪发票。"
    },
    "The ultimate multi-tenant SaaS platform built for modern global entrepreneurs. Professional invoices, job profitability tracking, and accountant-grade books.": {
        "ar": "منصة SaaS النهائية متعددة المستأجرين المصممة لرواد الأعمال العالميين الحديثين. فواتير احترافية، تتبع ربحية العمل، ودفاتر محاسبية عالية المستوى.",
        "en": "The ultimate multi-tenant SaaS platform built for modern global entrepreneurs. Professional invoices, job profitability tracking, and accountant-grade books.",
        "es": "La plataforma SaaS multitenencia definitiva creada para los emprendedores globales modernos. Facturas profesionales, seguimiento de la rentabilidad del trabajo y libros de nivel contable.",
        "fr": "La plateforme SaaS multi-tenant ultime conçue pour les entrepreneurs mondiaux modernes. Factures professionnelles, suivi de la rentabilité des missions et livres de niveau comptable.",
        "it": "La piattaforma SaaS multi-tenant definitiva costruita per i moderni imprenditori globali. Fatture professionali, monitoraggio della redditività del lavoro e libri contabili di livello professionale.",
        "ja": "現代のグローバルな起業家のために構築された究極のマルチテナントSaaSプラットフォーム。プロフェッショナルな請求書、業務の収益性追跡、および会計士レベルの帳簿。",
        "pt": "A plataforma SaaS multi-tenant definitiva construída para empreendedores globais modernos. Faturas profissionais, rastreamento de rentabilidade de projetos e livros contábeis de nível profissional.",
        "ru": "Лучшая многопользовательская SaaS-платформа, созданная для современных глобальных предпринимателей. Профессиональные счета, отслеживание рентабельности работы и бухгалтерия высшего уровня.",
        "zh": "专为现代全球企业家打造的终极多租户 SaaS 平台。专业的发票、项目盈利能力跟踪和会计级账簿。"
    },
    "Unified Ledger": {
        "ar": "دفتر أستاذ واحد",
        "en": "Unified Ledger",
        "es": "Libro unificado",
        "fr": "Grand livre unifié",
        "it": "Libro mastro unificato",
        "ja": "統合レジャー",
        "pt": "Razão unificado",
        "ru": "Единая учетная книга",
        "zh": "统一总账"
    },
    "V2.1 Enterprise Ready": {
        "ar": "V2.1 جاهز للمؤسسات",
        "en": "V2.1 Enterprise Ready",
        "es": "V2.1 Listo para empresas",
        "fr": "V2.1 Prêt pour l'entreprise",
        "it": "V2.1 Pronto per l'impresa",
        "ja": "V2.1 エンタープライズ対応",
        "pt": "V2.1 Pronto para empresas",
        "ru": "V2.1 Готов к корпоративному использованию",
        "zh": "V2.1 企业级就绪"
    },
    "[DEBIT]": {
        "ar": "[مدين]",
        "en": "[DEBIT]",
        "es": "[DÉBITO]",
        "fr": "[DÉBIT]",
        "it": "[DEBITO]",
        "ja": "[デビット]",
        "pt": "[DÉBITO]",
        "ru": "[ДЕБЕТ]",
        "zh": "[借方]"
    },
    "[RECORD]": {
        "ar": "[سجل]",
        "en": "[RECORD]",
        "es": "[REGISTRO]",
        "fr": "[ENREGISTREMENT]",
        "it": "[REGISTRAZIONE]",
        "ja": "[記録]",
        "pt": "[REGISTRO]",
        "ru": "[ЗАПИСЬ]",
        "zh": "[记录]"
    },
    "financial empire?": {
        "ar": "إمبراطوريتك المالية؟",
        "en": "financial empire?",
        "es": "¿imperio financiero?",
        "fr": "empire financier ?",
        "it": "impero finanziario?",
        "ja": "金融帝国を？",
        "pt": "império financeiro?",
        "ru": "финансовую империю?",
        "zh": "金融帝国？"
    },
    "mo": {
        "ar": "شهر",
        "en": "mo",
        "es": "mes",
        "fr": "mois",
        "it": "mese",
        "ja": "月",
        "pt": "mês",
        "ru": "мес",
        "zh": "月"
    },
    "sold": {
        "ar": "تم بيعه",
        "en": "sold",
        "es": "vendido",
        "fr": "vendu",
        "it": "venduti",
        "ja": "販売済み",
        "pt": "vendido",
        "ru": "продано",
        "zh": "已售"
    },
    "vollständig bezahlt": {
        "ar": "مدفوع بالكامل",
        "en": "fully paid",
        "es": "completamente pagado",
        "fr": "entièrement payé",
        "it": "completamente pagato",
        "ja": "完全支払い済み",
        "pt": "totalmente pago",
        "ru": "полностью оплачено",
        "zh": "完全支付"
    }
}

lang_dir = 'lang'
langs = ['ar', 'en', 'es', 'fr', 'it', 'ja', 'pt', 'ru', 'zh']

for lang in langs:
    file_path = os.path.join(lang_dir, f'{lang}.json')
    if not os.path.exists(file_path):
        print(f'Skipping {lang}, file not found')
        continue
    
    with open(file_path, 'r', encoding='utf-8') as f:
        try:
            data = json.load(f)
        except Exception as e:
            print(f'Error reading {lang}: {e}')
            continue
            
    for key, trans in keys_data.items():
        if lang in trans:
            data[key] = trans[lang]
            
    with open(file_path, 'w', encoding='utf-8') as f:
        json.dump(data, f, ensure_ascii=False, indent=4)
    print(f'Updated {lang}.json')
