with open('resources/views/verify.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

def print_line_indexes(search_str):
    for i, line in enumerate(lines):
        if search_str in line:
            print(f'{i}: {line.strip()}')

print_line_indexes('id="step-1"')
print_line_indexes('id="step-2"')
print_line_indexes('id="step-3"')
print_line_indexes('id="step-4"')
print_line_indexes('<script>')
