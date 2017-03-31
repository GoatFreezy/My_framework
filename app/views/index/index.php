<!DOCTYPE html>
<html>
<head>
	<title>Haloha</title>
</head>
<body>
{% for login in var %}
    {{ login }}
{% else %}
    No login have been found.
{% endfor %}
</body>
</html>