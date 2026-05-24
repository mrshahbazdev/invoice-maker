# El motor de facturación: una guía completa

La lógica central de esta plataforma gira en torno a un motor de facturación automatizado y muy avanzado diseñado para ayudarle a generar una facturación profesional sin problemas. Esta guía cubre el conjunto completo de funciones disponibles dentro del flujo de generación de facturas.

---

## 1. Iniciar una nueva factura
Crear una factura es sencillo. Navegue hasta su módulo **Facturas** y haga clic en **Crear nueva factura**. 
Esto inicia el generador de documentos interactivo de arrastrar y soltar.

### Metadatos de factura
Antes de agregar líneas de pedido, configurará los metadatos principales que definen el documento:
- **Número de factura:** De forma predeterminada, el sistema incrementa automáticamente los números de factura (por ejemplo, INV-0001 se convierte en INV-0002). Sin embargo, puede anular manualmente el prefijo y el esquema de numeración en su configuración global si utiliza un formato personalizado.
- **Fecha de emisión:** La fecha en que se genera oficialmente el documento. Los valores predeterminados son hoy.
- **Fecha de Vencimiento / Condiciones de Pago:** Define cuándo esperas recibir el dinero. Puede seleccionar fechas exactas o utilizar términos dinámicos como "Net 15", "Net 30" o "Vence al recibir". El sistema calculará automáticamente la fecha de vencimiento exacta en función de la fecha de emisión.
- **Selección de cliente:** Seleccione un cliente existente de su CRM o defina rápidamente uno nuevo en línea sin salir del creador.

---

## 2. Gestión de líneas de pedido
La sección de partidas individuales es donde se construye la factura real. 

### Agregar productos y servicios
Puede agregar líneas de pedido de dos maneras distintas:
1. **Entrada manual:** Escriba descripciones completamente personalizadas, precios arbitrarios y cantidades específicas directamente en una fila vacía. Esto es perfecto para trabajos de proyectos personalizados o tarifas de servicio únicas.
2. **Del inventario:** Haga clic en el menú desplegable "Agregar producto" para seleccionar artículos guardados previamente de su catálogo de productos/servicios. El sistema inyectará instantáneamente la descripción predefinida, el precio unitario y las tasas impositivas predeterminadas para ese artículo, lo que le permitirá ahorrar un tiempo inmenso.

### Matemáticas e impuestos en tiempo real
Toda la tabla está matemáticamente integrada.
- A medida que ajusta cantidades o precios unitarios, los totales de las filas se actualizan instantáneamente.
- **Impuestos de artículos de línea:** Puede asignar múltiples tasas impositivas (por ejemplo, un IVA regional y un impuesto sobre las ventas secundario) a un solo artículo de línea. El sistema calcula estos impuestos de forma dinámica e individual para cada fila.
- **Reordenación con arrastrar y soltar:** Tome el controlador en el lado izquierdo de cualquier fila para reordenar cómo aparecen los elementos en el PDF final. Las matemáticas continúan calculando perfectamente independientemente del pedido.

---

## 3. Descuentos y modificadores globales
A veces es necesario ajustar el total general más allá de las líneas de pedido individuales.

- **Descuentos globales:** En la parte inferior del generador de facturas, puede inyectar un descuento global. Puedes elegir si este descuento es un monto fijo literal (por ejemplo, "$50 de descuento") o un porcentaje del subtotal (por ejemplo, "10% de descuento"). El total general se actualiza dinámicamente para reflejar los ahorros.
- **Notas y términos:** Agregue un mensaje personalizado al cliente (como "¡Gracias por su negocio!") y defina términos y condiciones legales estrictos (como "Los pagos atrasados ​​conllevan una penalización del 5%").

---

## 4. Envío y Entrega
Una vez finalizada su factura, es hora de recibir el pago.

### Envío automatizado de correo electrónico
Al hacer clic en "Enviar factura" se abre el Iniciador de correo electrónico.
- El sistema carga automáticamente la dirección de correo electrónico principal asignada a su Cliente.
- Puedes personalizar en gran medida la línea de asunto y el cuerpo HTML del correo electrónico. Si ha definido una plantilla específica para este cliente en el CRM, estará precargada.
- La plataforma adjunta un PDF del documento bellamente generado y altamente comprimido directamente al correo electrónico saliente.

### Portal del cliente "Enlace mágico"
Fundamentalmente, el correo electrónico también contiene un "enlace mágico". Cuando su cliente hace clic en este enlace, se le dirige directamente a su Portal de cliente seguro y sin contraseña, donde puede ver la factura de forma dinámica.

### Seguimiento de estado
Una vez enviada una factura, el sistema comienza a rastrear su estado automáticamente:
- Verá exactamente cuándo el cliente abre el correo electrónico y ve el documento en línea (el estado cambia de Enviado a Visto).
- Si pasa la fecha de vencimiento, el sistema marca la factura con un distintivo rojo **Atrasado**.
- Cuando se registran los pagos (ya sea manualmente o mediante Stripe), el saldo se actualiza. Si se paga parcialmente, pasa a "Parcial". Si se liquida en su totalidad, se archiva como "Pagado".