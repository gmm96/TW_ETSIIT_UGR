# Práctica Final Tecnologías Web

## Aplicación web de un grupo de investigación

### 1. Descripción

![index](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_212944.png "index")

Para la realización de la práctica, se ha inventado un grupo de investigación informática, de nombre Innotechmon, que no existe en la vida real. De hecho y, como nota aclaratoria, cualquiera de los datos utilizados en esta práctica son pura invención.

Comentando un poco la estructura estática, nos encontramos con un **header** que muestra el nombre del grupo y un formulario para registrarnos, una parte central dividida en **aside + contenido**, y un **footer**, el cuál se divide a sí mismo en dos footers. El primero solo cambiará una vez hagamos login, mostrando un mensaje de bienvenida y un enlace para desconectarnos. En el segundo, el aside cambia dependiendo de si estamos registrados y con qué permisos (administrador o usuario simple). Por último, ambos footers no cambian.

En cuanto a la disposición de ficheros, se ha usado un único fichero *index.php*, el cual usará distintas funciones PHP dependiendo de un valor de la variable **$_GET**. El diseño de la web es resposive, de manera que se adaptará a cualquier pantalla. Se adjuntan algunas capturas de la página web en distintos dispositivos.

![Smartphone1](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213005.png "Smartphone1")

![Smartphone2](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213029.png "Smartphone2")

![Tablet1](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213047.png "Tablet1")

![Tablet2](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213114.png "Tablet2")

#### Usuario no registrado

Haciendo una primera vista de la web sin registrarnos, contamos con las siguientes páginas: *Inicio, Miembros, Proyectos, Publicaciones, Documentación*. Estas son iguales tanto para usuarios registrados como para usuarios no registrados. La única diferencia reside en la posibilidad de ver si un usuario se encuentra bloqueado en la lista de miembros, lo cual es posible si y solo si estamos registrados como administradores. A destacar también el formulario de búsqueda existente en la lista de publicaciones, el cual nos permitirá filtrarlas por tipo, autor, palabras clave o fecha.

![UserNotRegistered](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213128.png "UserNotRegistered")

#### Usuario registrado (miembro normal)

![Welcome](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213144.png "Welcome")


Si nos registramos con un usuario miembro no administrador, vemos como aparece un nuevo menú llamado **Investigación** en el aside. Aunque no se ha comentado anteriormente, los menús dispuestos en el aside son de tipo acordeón, al igual que los que se utilizan en la página de [PRADO2](www.prado.ugr.es). Esto quiere decir que solo se puede abrir uno a la vez. Este comportamiento se ha tomado siguiendo la directiva *mobile first*, ya que si varios de estos menús se pudiesen abrir de manera simultánea, estos ocuparían más espacio que el contenido principal en un smartphone, lo cuál carecería de sentido.

![RegUserSections](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213204.png "RegUserSections")


En este menú tenemos enlaces para la gestión de proyectos y publicaciones, pudiendo insertar, editar o borrar. Para la primera acción, tan solo tendremos que rellenar el formulario de registro, mientras que para las otras dos (edición y borrado) aparecerá antes un formulario para elegir el elemento que deseemos. Además, y como es obvio, el usuario registrado cuenta con todas las ventajas del usuario no registrado.

#### Usuario registrado (administrador)

Este tipo de usuario cuenta con otro **menú adicional**, en el cual tendrá la gestión de usuarios, la posibilidad de crear o restaurar un backup de la BBDD, revisar el log de la aplicación web o desinstalarla.

![AdminSections](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213226.png "AdminSections")


La gestión de usuarios tiene un comportamiento similar a la gestión de proyectos o publicaciones. La aplicación usa el sistema de backup de BBDD expuesto en el tema de teoría, con pequeñas modificaciones. Si realizamos la desinstalación de la aplicación web, se creará un **backup de la BBDD** que se mantendrá en el servidor, nos hará logout y borrará un archivo. Este archivo es el que indica a la aplicación web que se encuentra instalada en el momento, siguiendo un sistema similar al de *Moodle*.

Así, si realizamos la desinstalación, se nos mostrará un aviso indicando que no
se encuentra instalada y no podremos acceder a ninguna otra página.

![Error](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213241.png "Error")


En ese caso, el proceso de instalación consistiría en hacer login con un **usuario especial** únicamente habilitado cuando la aplicación web se encuentra desinstalada. Las credenciales de dicho usuario son las siguientes:

- Email: root
- Contraseña: root

Cuando nos hayamos logueado, se nos mostrará un dialogo de confirmación sobre si queremos **instalar la aplicación web**. Si así lo hacemos, esta usará el backup creado durante la desinstalación (u otro fichero que contiene la creación de todas las tablas si el primero no está disponible) y nos redireccionará hasta la página de creación de usuarios, dónde tendremos que crear un usuario administrador.

![Install](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/img/Screenshot_20181016_213256.png "Install")


Una vez creado el usuario administrador, debemos de hacer logout con el usuario root y comenzar a utilizar el usuario recién introducido.

#### Usuario registrado (director)

Como en el guíon de prácticas no se especificaba nada acerca de los permisos que tendría un usuario director del grupo, se ha usado simplemente a efectos informativos, teniendo en cuenta que todo usuario director computa como usuario administrador por sentido común. Esto es, ambos tipos de usuarios tienen los mismos privilegios. De la misma manera, se permiten varios usuarios directores.

### 2. Diseño de la BBDD

En cuanto al diseño de la BBDD, se ha obtado por el siguiente *esquema Entidad-Relación*. Para una mejor visualización, no se han trazado nada más que los atributos que serán clave primaria en cada entidad.

![ER](https://raw.githubusercontent.com/gmm96/TW_ETSIIT_UGR/master/ER.png "ER")


Se tiene en conocimiento que este diseño no es 100% correcto, ya que incumple varias restricciones al existir la posibilidad de un proyecto sin investigador principal, pero es la solución más cercana que se ha podido encontrar dada la descripción de los datos.

Lo ideal habría sido crear una entidad usuario, especializada en dos entidades miembro y usuario no registrado. De esta manera podríamos controlar sin saltarnos restricciones el investigador principal de un proyecto, pero al guardar únicamente nombre y apellidos del segundo tipo y, pudiendo estos repetirse, no tendría sentido alguno.

El paso a tablas tras la fusión (y traducción de los nombres) quedaría de la siguiente manera:
- **User** (email [CP], name, surname, category, director, pass, phone, url, department, center, university, address, photo, admin, blocked);
- **Project-Investigate** (cod [CP], title, description, ini-date, fin-date, associates, amount, url, non-group-main-invest, non-group-collabs, main-invest-email [CE User] );
- **Collaborate** (collab-invest-email [CP, CE User], project_cod [CP, CE Project-Investigate] );
- **Publication-Have** (doi [CP], title, date, abstract, keywords, url, non-group-authors, project_cod, subtype _{añadido para distinguir el tipo de publicación y obtener el resto de información}_);
- **Edit** (author-email [CP, CE User], pub-doi [CP, CE Publication-Have] );
- **Article** (doi [CP], journal, volume, pages);
- **Book** (doi [CP], publisher, editors, isbn);
- **BookChaper** (doi [CP], book-title, publisher, editors, isbn, pages);
- **Conference** (doi [CP], name, place, review);

Por último, puede consultar las sentencias para la creación de las tablas en el servidor MySQL en el fichero *tablas.sql* que se encuentra en el directorio root de la aplicación web, al mismo nivel que el index.php.


### 3. Tecnologías usadas

En cuanto a las tecnologías empleadas en este proyecto, destacan las siguientes:
- **AJAX (Asynchronous JavaScript And XML)**: usado en el formulario de creación de publicaciones. Cuando elegimos el tipo de publicación, se nos mostrarán varios inputs adicionales para introducir datos correspondientes al tipo de publicación. Su implementación se encuentra en la función displayAddingPost() del fichero php/controlador.php.
- **JavaScript**: usado para la validación de ciertos formularios. Su implementación se encuentra en el fichero js/validateForms.js.
- **Bootstrap**: se ha usado este framework basado en CSS + JavaScript para el diseño de aplicaciones web en todo el proyecto creado, siendo su principal tarea el diseño responsive del sitio web.
- **jQuery**: este framework para JavaScript se ha usado para modificar el aspecto físico de los menús del aside, eliminando o añadiendo una clase que controla el radio del border inferior del panel del título de cada menú según si este se encuentra abierto o cerrado. De esta manera, mejoramos su visibilidad y aspecto. Su implementación se puede observar en el fichero js/aside.js.


### 4. Aclaraciones varias

- En el formulario de adición de usuarios, si se selecciona que el usuario es director, se selecciona también automáticamente que el usuario será administrador, no pudiendo deseleccionar este último.
- En todos los formularios de edición de registros, ya sean proyectos, usuarios, etc., no podremos editar la clave privada correspondiente a cada entidad. Además, en el caso de los usuarios, tampoco podremos modificar su nombre. Se ha tomado esta decisión apelando a la lógica.
- Todos los registros entrantes en la BBDD se han escapado correctamente usando la función **mysqli_real_escape_string()** de PHP.
- Todos los registros salientes de la BBDD se han escapado correctamente usando la función **htmlspecialchars()** de PHP.
- El comportamiento elegido en la BBDD en el caso de que borremos una entrada referenciada en otra tabla ha sido **borrado en cascada**. No se ha escogido ningún comportamiento para la actualización, ya que no es necesaria al no dejar modificar la claves primarias de cada entidad.
- Para el log, se ha utilizado un archivo de texto plano que se encuentra en el directorio *root* de la aplicación web.
- Se sabe que los ficheros que se suben al servidor deberían de ser guardados en directorios no accesibles desde el servidor web, pero por limitaciones del servidor utilizado para la práctica, no se ha podido realizar esta tarea.
- El mecanismo usado para iniciar sesión en la aplicación web ha sido el uso de la variable **$_SESSION** de PHP.
- Se ha tenido que usar el elemento *!important* en varias reglas CSS. Esto es debido a que, para ciertos elementos HTML, las reglas introducidas no se reproducían en el navegador, ya que las reglas provenientes de *Bootstrap* tenían mayor prioridad. Añadiendo está cláusula, conseguimos invalidar el comportamiento original y sustituirlo por el que deseamos.
- Tal y como se puede comprobar tras el uso de Bootstrap y la inclusión de una serie de elementos, el tipo de diseño es *mobile first*, es decir, el contenido se diseña para dispositivos móviles y luego se adapta a pantalla de mayor tamaño/resolución.