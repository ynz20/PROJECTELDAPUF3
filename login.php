<?php

// Valida l'inici de sessió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"]; // Obté el nom d'usuari del formulari
    $password = $_POST["password"]; // Obté la contrasenya del formulari i la xifra

    $ipserverLdap = "ldap://192.168.1.100"; // Defineix la direcció IP del servidor LDAP

    // Realitza l'autenticació amb phpLDAPadmin
    $ldapconn = ldap_connect($ipserverLdap) or die("No hem pogut realitzar la connexió al servidor.");

    if ($ldapconn) {
        // Estableix opcions de LDAP
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

        // Intenta enllaçar-se al servidor LDAP
        $ldapbind = @ldap_bind($ldapconn, "cn=$username,cn=usuaris,cn=admin,dc=grupays,dc=com", $password);

        if ($ldapbind) {
            // Redirigeix a la pàgina de fotos de mamuts si l'autenticació és exitosa
            header("Location: menuInici.html");
            exit; // Assegura que l'script s'aturi després de la redirecció
        } else {
            // Imprimeix un missatge d'error si l'autenticació falla
            echo "Error autenticació: " . ldap_error($ldapconn);
        }
    } else {
        // Imprimeix un missatge si la connexió LDAP falla
        echo "Connexió no vàlida.";
    }

    // Tanca la connexió LDAP
    ldap_close($ldapconn);
}

?>

