<?php

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Conexión LDAP
    $ldapconn = ldap_connect("ldap://192.168.1.100") or die("No se pudo conectar al servidor LDAP.");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

    if ($ldapconn) {
        // Autenticación con el servidor LDAP (aquí debes usar un usuario con permisos suficientes para agregar usuarios)
        $ldapbind = ldap_bind($ldapconn, "cn=admin,dc=grupays,dc=com", "tu_contraseña_admin");

        if ($ldapbind) {
            // Define los atributos del nuevo usuario
            $entry["cn"] = $username;
            $entry["sn"] = $username;
            $entry["objectclass"][0] = "top";
            $entry["objectclass"][1] = "person";
            $entry["objectclass"][2] = "organizationalPerson";
            $entry["objectclass"][3] = "inetOrgPerson";
            $entry["userPassword"] = $password;
            $entry["mail"] = $email;

            // Intenta agregar el usuario al directorio LDAP
            $dn = "cn=$username,cn=usuaris,cn=admin,dc=grupays,dc=com";
            $add = ldap_add($ldapconn, $dn, $entry);

            if ($add) {
                echo "Usuario agregado correctamente.";
            } else {
                echo "Error al agregar el usuario: " . ldap_error($ldapconn);
            }
        } else {
            echo "Error de autenticación con el servidor LDAP.";
        }

        // Cierra la conexión LDAP
        ldap_close($ldapconn);
    } else {
        echo "No se pudo conectar al servidor LDAP.";
    }
} else {
    // Si no se ha enviado el formulario, redirecciona a la página de inicio
    header("Location: index.html");
    exit;
}

?>
