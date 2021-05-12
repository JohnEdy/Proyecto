PROYECTO Parqueo

EN EL SCRIPT DE BD SQL YA VIENE PARA CREAR SU BASE DE DATOS CON NOMBRE PREDETERMINADO, SOLO DEBE EJECUTARSE EN SU GESTOR BD

La idea de la creación del software es para uno o varios parqueaderos, manejando el retiro de un vehículo mediante un código que el cliente podrá generar ingresando con su usuario (el cual se puede crear desde un usuario con los roles de administrador de empresas y/o cajero) teniendo en cuenta que la información está siempre relacionada a la empresa a la cual pertenece dicho usuario logueado.

FUNCIÓN DE CADA ROL:

Existen cuatro roles dentro del aplicativo:

1 - Administrador del Sistema: es la persona o personas encargadas de manejar los pagos (esta parte se ve accesible en el menú, pero esta en construcción) de cada empresa, pudiendo eliminar, deshabilitar o crear empresas, según la situación lo amerite. Entonces, dicho rol, podrá crear un usuario con rol administradorEmpresas, el cual se relacionará a dicha empresa creada anteriormente. Cabe aclarar que este usuario podrá crear usuarios para todas las empresas con todos los roles (administradorSistema, administradorEmpresas, cajeroEmpresas y clienteEmpresas)
El cual se maneja por roles para ejecutar dichas acciones.

2 - administradorEmpresas: es la persona que contrata el servicio del software (es decir, el dueño de un parqueadero), es aquella persona que controla la configuración de la empresa, desde las operaciones que se realizan en diferenta parqueadero (parqueo por horas, parqueo por meses, lavada de autos y venta de artículos), habilitando o deshabilitando dichas a opciones según su configuración, también es la que da valores a cada acción que se realice en la empresa. Esta persona también podrá revisar los parqueos del día o los parqueos anteriores, también podrá realizarle arqueos a cada uno de los cajeros que tenga dicha empresa. Sumandole a esto, que cada persona con dicho rol, podrá enviarle ordenes por escrito  o solicitudes a los administradores del sistema o a sus cajeros; así cómo ver las solicitudes enviadas por él y las que le envían a él. El administrador de la empresa también podrá realizar funciones de cajero.

3 - cajeroEmpresas: es la persona que puede registrar un parqueo, un usuario (pero solamente con rol de cajero o cliente) y también un vehículo. Teniendo también acceso a las diferentes opciones que el administrador de la empresa habilite. Teniendo en cuenta, que al momento de registrar un parqueo, tengo la opción de ingresar el cliente cómo va retirar el vehículo del lugar si con fáctura o con código. Si se elige la opción fáctura, se abrirá una pestaña con la fáctura generada. Pero si se elige código, sólo aparecerá una alerta de que se ha ingresado correctamente el parqueo.

4 - clienteEmpresasa: es la persona que podrá consultar que parqueos tiene activos, cuales ya retiro y retirar su vehículo mediante el código generado al revisar el parqueo.

Agregando a todo esto, cada usuario podrá revisar su información donde aparece su información dando click, en el submenú perfil, allí podrá editar toda su información como también, cambiar su foto de perfil y/o su contraseña.

Al momento de crear cualquier usuario, el mismo sistema te asigna una clave de cuatro digitos, los cuales son los últimos cuatro digitos de dicho usuario y, al momento de ingresar por primera con esa contraseña, te pedirá cambiarla. También, si es la primera vez que se ingresa como administrador de empresa y no existe una configuración almacenada, el sistema te dirige para que ingreses dicha configuración.

Las empresas que se registren gratuitamente, es decir, que no se le has registrado un pago, sea desde el plan medium o premium, no podrán realizar más de 30 registros de parqueos por día, teniendo en cuenta que dichas empresas sólo podrán realizar registros de parqueos por hora sin acceso a las otras opciones.

LOS USUARIOS PARA REALIZAR LAS PRUEBAS SON LOS SIGUIENTES:

Sus usuarios de prueba los puede crear ingresando en la pagina web sotfpark.epizy.com en el apartado de Registrarse, debe ingresar una empresa y posterior a esto, ingresar su usuario.

APLICATIVO CREADO POR: CESAR TRUJILLO
CORREO CONTACTO: trujillogarciac2@gmail.com