import re
with open('resources/views/verify.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

ids = re.findall(r'<(?:input|select|textarea)[^>]*?id=[\x27\x22]([^\x27\x22]+)[\x27\x22]', content)
print(ids)
