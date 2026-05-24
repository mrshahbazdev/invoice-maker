# Productos y control de inventario: guía completa de funciones

Volver a escribir constantemente las mismas descripciones de artículos, precios y tasas impositivas cada vez que genera una factura es ineficiente y propenso a errores. El módulo **Productos** actúa como su catálogo central y sistema básico de gestión de inventario, diseñado para acelerar radicalmente su flujo de trabajo de facturación.

---

## 1. Creando tu catálogo maestro
Navegue a la pestaña **Productos** para comenzar a crear su base de datos de bienes y servicios.

### Configuración de artículo estándar
Al definir un nuevo producto o servicio, puede configurar varios valores predeterminados permanentes:
- **Nombre y descripción del artículo:** Escriba una descripción clara y profesional. Este texto exacto aparecerá en la línea de pedido de la factura, lo que garantizará que sus clientes siempre reciban explicaciones coherentes sobre lo que están comprando.
- **Precio unitario predeterminado:** Establezca su tarifa estándar. Ya sea que cobre $150 por hora por consultoría o $25 por un widget físico, guardarlo aquí significa que nunca más tendrá que buscar precios.
- **Reglas tributarias:** Diferentes artículos a menudo tienen obligaciones tributarias diferentes (por ejemplo, los bienes físicos pueden tener un impuesto sobre las ventas del 10 %, mientras que los servicios digitales pueden estar exentos de impuestos). Puede asignar una *Tasa impositiva predeterminada* específica a un artículo. Cuando agrega este artículo a una factura, el sistema aplica automáticamente los cálculos de impuestos correctos sin que usted mueva un dedo.

---

## 2. Gestión automatizada de existencias e inventarios
Si su empresa vende productos físicos en lugar de servicios abstractos, es fundamental realizar un seguimiento exacto de cuántos artículos quedan en el almacén. La plataforma cuenta con un sistema de microinventario automatizado.

### Habilitación del seguimiento de existencias
Al crear o editar un producto físico, simplemente mueva el interruptor **"Administrar stock"** a la posición ON.
- Se le pedirá que ingrese su **Cantidad actual disponible** (por ejemplo, 500 unidades).
- Esto establece su inventario base para este SKU específico.

### Deducción automática en tiempo real
La magia del sistema de inventario ocurre durante la fase de facturación de forma totalmente automática.
- Cada vez que finalizas y envías una **Factura** que contiene un producto con stock administrado, el sistema lee inmediatamente la cantidad facturada en esa factura y la deduce de tu base de datos maestra.
- *Ejemplo:* Si tienes 500 widgets y envías una factura facturando a un cliente 50 widgets, tu stock maestro baja automáticamente a 450.
- Esto garantiza que nunca sobrevendas accidentalmente un artículo que ya no posees. 
- *Nota:* Las estimaciones no descuentan stock, ya que no son ventas finalizadas. Sólo las facturas activas enviadas activan la lógica de deducción.

---

## 3. Integración rápida de facturación
El verdadero poder del módulo Productos se logra cuando realmente estás creando una factura o cotización.

- Dentro del Generador de facturas, en lugar de escribir en la fila en blanco, haga clic en el menú desplegable **"Agregar producto"**.
- Seleccione su artículo preconfigurado.
- El sistema completa instantáneamente la descripción, establece el precio unitario, aplica el impuesto correcto y calcula el total de la fila. 
- Crear una factura compleja de 20 artículos lleva apenas unos segundos en lugar de varios minutos de entrada manual de datos.

---

## 4. Edición y ajustes de costos
Los precios evolucionan con el tiempo según los costos de los proveedores o la demanda del mercado.
- Puedes editar libremente el precio predeterminado de cualquier artículo de tu catálogo maestro en cualquier momento.
- **Integridad histórica:** Modificar el precio de un artículo del catálogo *no* altera las facturas antiguas ya enviadas. Sus registros financieros históricos permanecen perfectamente intactos, mientras que todas las facturas recién generadas heredarán la lógica de precios actualizada.