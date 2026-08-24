import os
import re

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    original_content = content

    # 2. Inject wire:navigate
    def replace_a_tag(match):
        tag = match.group(0)
        
        # Check if it already has wire:navigate
        if 'wire:navigate' in tag:
            return tag
            
        # Check if it's an external link or has target="_blank" or download
        if 'target="_blank"' in tag or "target='_blank'" in tag or 'download' in tag:
            return tag
            
        # Check href
        href_match = re.search(r'href=(["\'])(.*?)\1', tag)
        if not href_match:
            return tag
            
        href = href_match.group(2)
        
        # Exceptions
        if href.startswith('http') or href.startswith('#') or href.startswith('mailto:') or href.startswith('tel:'):
            return tag
            
        # Inject wire:navigate right after <a
        return tag[:2] + ' wire:navigate' + tag[2:]

    # Match <a ... > where ... can contain -> or => or any character except > 
    # To handle -> and => which contain >, we use (?:[^>]|->|=>)*
    content = re.sub(r'<a\b(?:[^>]|->|=>)*>', replace_a_tag, content)

    if content != original_content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated {filepath}")

views_dir = r"c:\laragon\www\mitra-dpmptsp\resources\views"
for root, dirs, files in os.walk(views_dir):
    for file in files:
        if file.endswith('.blade.php'):
            process_file(os.path.join(root, file))

print("Done processing views round 2.")
