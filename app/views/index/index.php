<!DOCTYPE html>
<html>
<head>
	<title>Haloha</title>
</head>
<body>
{% for user in users %}
    {{ user }}
{% else %}
    No login have been found.
{% endfor %}
</body>
</html>