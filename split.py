import os

with open('resources/views/verify.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

def get_block(start_idx, end_idx):
    return "".join(lines[start_idx:end_idx])

# Based on exact lines
header = get_block(0, 86)

# In the header, replace action="/review" method="GET" with action="{{ route('verify.store') }}" method="POST"
header = header.replace('action="/review"', 'action="{{ route(\'verify.store\') }}"')
header = header.replace('method="GET"', 'method="POST"')
# Add @csrf inside the form. The form tag is around line 84.
# Let's insert @csrf right after the form tag
form_tag = '<form action="{{ route(\'verify.store\') }}" method="POST" id="verify-form" enctype="multipart/form-data">'
if '<form action="/review" method="GET" id="verify-form" enctype="multipart/form-data">' in header:
    header = header.replace('<form action="/review" method="GET" id="verify-form" enctype="multipart/form-data">', form_tag + '\n                    @csrf')

step1 = get_block(86, 176)
step2 = get_block(176, 275)
step3 = get_block(275, 388)
step4 = get_block(388, 502) # includes buttons and map modal
scripts = get_block(502, len(lines)-2) # Up to </body>

# Create new index file
with open('resources/views/verify/index.blade.php', 'w', encoding='utf-8') as f:
    f.write(header)
    f.write('                            @include(\'verify.partials.step1\')\n')
    f.write('                            @include(\'verify.partials.step2\')\n')
    f.write('                            @include(\'verify.partials.step3\')\n')
    f.write('                            @include(\'verify.partials.step4\')\n')
    f.write('                        </div>\n')
    # the buttons are in step4 now! wait, in original they were after step 4.
    # Ah, step4 goes from 388 to 502, which INCLUDES the closing </div> of the step-sections wrapper?
    # Wait, in the original HTML:
    # 388: <div id="step-4" class="p-6 sm:p-10 step-section hidden">
    # 449: </div>
    # 451: <!-- Navigation Buttons -->
    # 465: </form>
    # 475: <!-- Map modal -->
    # So step4 has the closing of the form.
    # We should let the index file be clean.
    pass

# We will just write the partials as is for now, and then add name attributes manually or via script.
with open('resources/views/verify/partials/step1.blade.php', 'w', encoding='utf-8') as f:
    f.write(step1)
with open('resources/views/verify/partials/step2.blade.php', 'w', encoding='utf-8') as f:
    f.write(step2)
with open('resources/views/verify/partials/step3.blade.php', 'w', encoding='utf-8') as f:
    f.write(step3)
with open('resources/views/verify/partials/step4.blade.php', 'w', encoding='utf-8') as f:
    f.write(step4)
with open('resources/views/verify/partials/scripts.blade.php', 'w', encoding='utf-8') as f:
    f.write(scripts)

# Now, write index file differently
# Step 1-3 is just the divs. Step 4 contains closing tags.
# Actually, it's safer to just split it this way:
index_content = header + \
    "                            @include('verify.partials.step1')\n" + \
    "                            @include('verify.partials.step2')\n" + \
    "                            @include('verify.partials.step3')\n" + \
    "                            @include('verify.partials.step4')\n" + \
    "                            @include('verify.partials.scripts')\n" + \
    "</body>\n</html>"

with open('resources/views/verify/index.blade.php', 'w', encoding='utf-8') as f:
    f.write(index_content)
