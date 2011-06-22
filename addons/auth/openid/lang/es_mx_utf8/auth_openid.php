<?php

global $CFG;

// Plugin title & description strings (from: /lang/en_utf8/auth.php)
$string['auth_openidtitle'] = 'AbreID';
$string['auth_openiddescription'] = 'OpenID es un proceso abierto, marco descentralizado, libre de identidad digital centrada en el usuario. Para obtener más información, visite <a href=\"http://openid.net/\">OpenID.net</a>.';

// Module strings
$string['modulename'] = 'OpenID';
$string['whats_this'] = '¿Qué es esto? ?';
$string['provider_offline'] = 'Ayuda, mi proveedor no está en línea! ';

// Block strings
$string['block_title'] = 'OpenID';
$string['append_text'] = 'Usted puede agregar otro OpenID a su cuenta mediante la introducción de otro OpenID aquí ';
$string['change_text'] = 'Usted puede cambiar su cuenta de OpenID introduciendo OpenID aquí ';

// Login strings
$string['openid_email_subject'] = 'Moodle: la autenticación OpenID ';
$string['openid_email_text'] = '{$a->username},\n\nCongratulations, su cuenta de Moodle en {$a->moodle_site}\nes ahora OpenID\n\nPor favor, guardar su única dirección URL de OpenID. {$a->openid_url}\nNo podrá exigir que si su proveedor de OpenID es siempre fuera de servicio de línea.\n\n--\n{$a->admin_name}';
$string['openid_enabled'] = 'Estamos OpenID Activado ';
$string['openid_enabled_google'] = 'Ingresar con tu cuenta de Google OpenID ';
$string['openid_text'] = 'Usted puede identificarse o registrarse aquí con su correo electrónico de Google o la dirección URL de OpenID .';
$string['openid_note'] = '¿Ya tienes una cuenta aquí y quieres iniciar sesión con tu OpenID nuevo? Sólo tienes que introducir tu OpenID una vez que \"he iniciado la sesión como normal y que \'ll enlace su cuenta para su OpenID';
$string['openid_note_user'] = 'Para crear una cuenta separada con su OpenID, debe <a wwwroot href=\"{$a->href}\">{$a->logout}</a>.';
$string['openid_redirecting'] = 'Va a ser redirigido a su proveedor de OpenID. Si no es redirigido automáticamente, por favor haga clic en el botón de continuar por debajo.';

// Fallback strings
$string['fallback_text'] = 'Cuando se introduce un OpenID registrado aquí, le enviaremos un enlace de una sola vez a la dirección de correo electrónico asociada con ese OpenID para permitir que se conecte sin tener que autenticarse con su proveedor de OpenID. Esto puede ser útil si su proveedor de OpenID no está en línea, por alguna razón, o si no registrados con su proveedor y se olvidó de actualizar su cuenta.';
$string['fallback_message_sent'] = 'Un correo electrónico fue enviado a la dirección registrada en el OpenID con un enlace a una página de acceso de una sola vez .';
$string['emailfallbacksubject'] = '$a: entrada de una sola vez ';
$string['emailfallback'] = 'Hola $a->firstname,

Una entrada de una sola vez se ha solicitado en \'$a->sitename\'
para su OpenID ($a->openid_url).

Para iniciar la sesión sin necesidad de acceder a su proveedor de OpenID,
por favor vaya a esta dirección web:

$a->link

En la mayoría de los programas de correo, este debe aparecer como un enlace azul
que acaba de hacer clic en. En caso de que el trabajo no tiene
 continuación, cortar y pegar la dirección en la dirección
línea en la parte superior de la ventana del navegador web.

Este vínculo sólo funcionará una vez y tiene una duración limitada a 30
minutos desde el momento que fue solicitada.

Si usted necesita ayuda, póngase en contacto con el administrador del sitio,
$a->admin
';

// Action strings
$string['confirm_sure'] = '¿Seguro que quieres hacer esto?';
$string['confirm_append'] = 'Usted está a punto de añadir la identidad, a $a su cuenta.  '.$string['confirm_sure'];
$string['confirm_change'] = 'Usted está a punto de cambiar su cuenta de OpenID utilizando la identidad de $a.Esto va a cambiar sus datos de acceso y evitar que se puedan conectar con su método actual  '.$string['confirm_sure'];
$string['confirm_delete'] = 'Usted está a punto de eliminar las siguientes identidades de su cuenta:';
$string['action_cancelled'] = 'Acción cancelada. No se han realizado cambios a su cuenta.';
$string['cannot_delete_all'] = 'Lo sentimos, pero no se puede eliminar todas sus OpenID.';

// Profile strings
$string['openid_manage'] = 'Administre su OpenID';
$string['add_openid'] = 'Agregar a su cuenta de OpenID';
$string['openid_main'] = '(OpenID Principal)';
$string['delete_selected'] = 'Eliminar seleccionados';

// Error strings
$string['auth_openid_email_mismatch'] = 'Correo electrónico del usuario no coincide con OpenID de correo electrónico: ';
$string['auth_openid_multiple_disabled'] = 'Lo sentimos, pero ya no se puede iniciar sesión con OpenID múltiples en este sitio. Póngase en contacto con el propietario del sitio.';
$string['auth_openid_server_blacklisted'] = 'Lo sentimos, no aceptamos registros de su servidor de OpenID, $a';
$string['auth_openid_url_exists'] = 'Lo sentimos, pero el OpenID, $a, ya está registrado aquí';
$string['auth_openid_user_cancelled'] = 'Autenticación cancelada por el usuario';
$string['auth_openid_login_failed'] = 'Error de autenticación. Servidor informó: $a';
$string['auth_openid_login_error'] = 'Ocurrió un error al autenticar con su proveedor de OpenID. Por favor, compruebe la URL de OpenID y vuelva a intentarlo.';
$string['auth_openid_filestore_not_writeable'] = 'No podía escribir en el directorio de almacenamiento de archivo. Por favor asegúrese de los directorios de moodle / auth / OpenID / store / se puede escribir y vuelva a intentarlo';
$string['auth_openid_multiple_matches'] = 'No se puede autenticar. Respuesta OpenID varias coincidencias usuarios existentes.';
$string['auth_openid_no_multiple'] = '.';
$string['auth_openid_require_account'] = 'No se puede autenticar. Este sitio está configurado para no permitir que los nuevos usuarios a través de OpenID.';

// Tabs
$string['openid_tab_users'] = 'Usuarios';
$string['openid_tab_sreg'] = 'Simple extensión de registro';
$string['openid_tab_servers'] = 'Servidores';

// Config strings
$string['allow'] = 'Permitido';
$string['confirm'] = 'Confirmado ';
$string['deny'] = 'Denegado ';
$string['auth_openid_confirm_switch'] = 'Requerir que los usuarios confirman cuando se cambia de autenticación OpenID .';
$string['auth_openid_create_account'] = 'Permitir la creación de nuevas cuentas de MOODLE para OpenID nueva autenticación de los usuarios .';
$string['auth_openid_custom_login'] = 'Personalizado OpenID login :';
$string['auth_openid_custom_login_config'] = 'Se puede sustituir el valor por defecto OpenID campos de entrada con su nombre de usuario personalizadas (ruta de acceso relativa). . Deja en blanco para el formulario predeterminado OpenID URL <br/> Para forzar el uso por defecto OpenID entrada: <a <br/> href=\'$a\'> $a </a> ';
$string['auth_openid_email_on_change'] = 'Enviar aviso por correo electrónico a los usuarios cuando se cambia de autenticación OpenID.';
$string['auth_openid_limit_login'] = 'Página Límite entrada a la autenticación OpenID sólo <br/> <small> <b> Nota </b>: Para utilizar la autenticación de inicio de sesión con OpenID no: <A HREF=\'$a\'> $a </A> </small> ';
$string['auth_openid_match_fields'] = 'Coincidar OpenID atributos :';
$string['auth_openid_match_fields_config'] = 'Coincidencia existente Moodle campos con los atributos de usuario de OpenID para el cambio automático o de agregar de inicios de sesión OpenID. Los valores permitidos, separados por comas son: correo electrónico <i> <br/>, nombre completo, nombre de usuario, username_email </i>. Emparejado en el orden indicado. <br/> Deja en blanco para ninguna conversión automática a OpenID ';
$string['auth_openid_sso_settings'] = 'OpenID Single Sign-On (SSO), configuración';
$string['auth_openid_sso_description'] = 'Este plug-in de autenticación, una vez configurado, funciona como el sistema de autenticación única en su sitio. Esto puede ser útil si usted está planeando sobre el uso de OpenID como un proveedor de identidad interna <br /> <br /> <strong>. Importante: Antes de entrar en una dirección URL del servidor, por favor asegúrese de tener al menos un usuario registrado en su contra con permisos administrativos (permisos de usuario-> Asignar roles globales-> Administrador). Si tiene que volver a iniciar sesión con un nombre de usuario y contraseña normales una vez que este plugin está habilitado, se puede reemplazar añadiendo el parámetro de consulta \"admin \"a la URL de inicio de sesión (por ejemplo: http://yoursite/moodle/login/index.php?admin=true). </strong> ';
$string['auth_openid_sso_op_url_key'] = 'URL del servidor ';
$string['auth_openid_sso_op_url'] = 'Esta es la URL del servidor OpenID que desea utilizar como su proveedor de SSO.';
$string['auth_openid_sreg_settings'] = 'Simple registro de extensión (SREG) configuración ';
$string['auth_openid_sreg_description'] = 'DE INSCRIPCIÓN OpenID es una simple extensión del protocolo de autenticación OpenID que permite el cambio de perfil muy ligero. Está diseñado para pasar ocho piezas solicitadas de información cuando un usuario final va a registrar una nueva cuenta con un servicio web. <br /> <br /> Campos <a href=\"http://openid.net/specs/openid-simple-registration-extension-1_0.html\"> definido por el especificación </a> son: nick, correo electrónico, nombre completo, fecha de nacimiento, sexo, código postal, país, idioma y zona horaria. Este plugin procesa actualmente: apodo, correo electrónico, nombre completo y país ';
$string['auth_openid_sreg_required_key'] = 'Los campos obligatorios ';
$string['auth_openid_sreg_required'] = 'Lista separada por comas de los campos. Al añadir a esta lista de campos que se indica que el usuario no será capaz de completar el registro sin ellos y el proveedor de OpenID puede ser capaz de acelerar el proceso de registro mediante la devolución de ellos. <em> campos obligatorios no están garantizados para ser devuelto por un proveedor de OpenID. </em> ';
$string['auth_openid_sreg_optional_key'] = 'Los campos opcionales ';
$string['auth_openid_sreg_optional'] = 'Lista separada por comas de los campos. Al añadir a esta lista de campos que se indica que el usuario podrá registrarse sin ellos, sino que se utilizará si el proveedor de OpenID los envía ';
$string['auth_openid_privacy_url_key'] = 'Política de privacidad ';
$string['auth_openid_privacy_url'] = 'Si publica una política de privacidad online, escriba la dirección URL completa aquí usuarios para OpenID puede leerlo. <em> Sólo se utiliza si los campos se especifican SREG </em> ';
$string['auth_openid_user_settings'] = 'OpenID Ajustes del usuario ';
$string['auth_openid_user_description'] = 'Configuración para permitir o impedir que los usuarios lleven a cabo ciertas acciones ';
$string['auth_openid_allow_account_change_key'] = 'Permitir a los usuarios cambiar su tipo de cuenta a través de la autenticación OpenID con un proveedor de OpenID ';
$string['auth_openid_allow_muliple_key'] = 'Permitir a los usuarios a registrarse más de una identidad para cada cuenta?';
$string['auth_openid_servers_settings'] = 'Configuración del servidor';
$string['auth_openid_servers_description'] = 'Administrar la lista de servidores OpenID que están permitidos o bloqueados automáticamente. Usted puede utilizar wilcards como *.myopenid.com. <br /> <br /> <small> <em> Si tiene marcada la opción de requerir que los usuarios de servidores que no sean la lista blanca para confirmar su inscripción a continuación, los servidores de establecer como \'confirmar \"se comportan como servidores de establecer como \" permitir \'. </em></small>';
$string['openid_non_whitelisted_status'] = 'Servidores de la que no son en la lista blanca deben ser: ';
$string['openid_non_whitelisted_info'] = '<small> <strong> Nota: </strong> <em> confirmada </em> de registro sólo se utiliza cuando una solicitud de otro modo se completa de forma automática sin intervención humana (por ejemplo: ¿dónde OpenID registro de datos cubre los requisitos de registro como mínimo). </small>';
$string['openid_require_greylist_confirm_key'] = 'Requerir que los usuarios de servidores que no sean la lista blanca para confirmar su registro? <small> Sólo se utiliza cuando una solicitud de otro modo se completa de forma automática sin intervención humana (por ejemplo: ¿dónde simple registro de datos cubre los requisitos de registro mínimo) </small>';

?>
