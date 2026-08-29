import re
import os

files = [
    'resources/views/verify/partials/step1.blade.php',
    'resources/views/verify/partials/step2.blade.php',
    'resources/views/verify/partials/step3.blade.php',
    'resources/views/verify/partials/step4.blade.php'
]

def repl(m):
    tag = m.group(1)
    attrs = m.group(2)
    # find id value
    id_match = re.search(r'id=[\x27\x22]([^\x27\x22]+)[\x27\x22]', attrs)
    if id_match and 'name=' not in attrs:
        id_val = id_match.group(1)
        name_val = id_val.replace('-', '_')
        return f'<{tag} name="{name_val}" {attrs}>'
    return m.group(0)

for file in files:
    if os.path.exists(file):
        with open(file, 'r', encoding='utf-8') as f:
            content = f.read()
        new_content = re.sub(r'<(input|select|textarea)([^>]+)>', repl, content)
        with open(file, 'w', encoding='utf-8') as f:
            f.write(new_content)
