/**
 * OneBlog native Emoji picker.
 * New comments store Unicode Emoji directly and use the visitor's system glyphs.
 */
document.addEventListener('DOMContentLoaded', function() {
    const emojiBtn = document.getElementById('emoji-btn');
    const emojiPicker = document.getElementById('emoji-picker');
    const emojiContainer = document.querySelector('.emoji-container');
    const emojiCategories = document.querySelectorAll('.emoji-category');
    const richEditor = document.getElementById('rich-editor');
    const textarea = document.getElementById('textarea');

    if (!emojiBtn || !emojiPicker || !emojiContainer || !richEditor || !textarea) return;

    const emojiData = {
        emotion: [
            '🥰', '😋', '😘', '🥳', '🤩', '😄', '😍',
            '😇', '🤣', '😊', '🙂', '😂', '🫡', '😭',
            '😉', '😆', '😅', '😎', '🤔', '😏', '🥺',
            '😴', '🥱', '😐', '😷', '😟', '😮', '☹️',
            '🫠', '😢', '🙄', '😩', '😠', '😈'
        ],
        special: [
            '🎉', '🎁', '☀️', '✨', '🍻', '❤️', '💔', '✅', '❌', '👣'
        ],
        kaomoji: [
            '(✪ω✪)', '(*^▽^*)', '٩(๑❛ᴗ❛๑)۶',
            '(๑´ㅂ`๑)', '(◕ᴗ◕✿)', '(๑¯∀¯๑)',
            '(＾ω＾)', '(★ᴗ★)', '(*^__^*)',
            '(╯︵╰)', '(T＿T)', '╥﹏╥',
            '(｡•́︿•̀｡)', '>_<', '(•ˇ‸ˇ•｡)',
            '｡◕ᴗ◕｡', '(´•༝•`)'
        ]
    };

    let savedRange = null;
    let lastActiveCategory = 'emotion';

    emojiBtn.setAttribute('role', 'button');
    emojiBtn.setAttribute('tabindex', '0');
    emojiBtn.setAttribute('aria-controls', 'emoji-picker');
    emojiBtn.setAttribute('aria-expanded', 'false');

    function selectionIsInsideEditor(range) {
        return range && richEditor.contains(range.commonAncestorContainer);
    }

    function saveSelection() {
        const selection = window.getSelection();
        if (!selection || !selection.rangeCount) return;

        const range = selection.getRangeAt(0);
        if (selectionIsInsideEditor(range)) {
            savedRange = range.cloneRange();
        }
    }

    function moveCursorToEnd() {
        const range = document.createRange();
        range.selectNodeContents(richEditor);
        range.collapse(false);
        savedRange = range;
    }

    function restoreSelection() {
        if (!savedRange || !document.contains(savedRange.commonAncestorContainer)) {
            moveCursorToEnd();
        }

        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(savedRange);
        richEditor.focus();
    }

    function insertFragment(fragment) {
        restoreSelection();

        const selection = window.getSelection();
        const range = selection.getRangeAt(0);
        const lastNode = fragment.lastChild;

        range.deleteContents();
        range.insertNode(fragment);

        if (lastNode) {
            range.setStartAfter(lastNode);
            range.collapse(true);
            selection.removeAllRanges();
            selection.addRange(range);
            savedRange = range.cloneRange();
        }

        syncTextarea();
    }

    function insertText(text) {
        const fragment = document.createDocumentFragment();
        fragment.appendChild(document.createTextNode(text));
        insertFragment(fragment);
    }

    function insertPlainText(text) {
        const fragment = document.createDocumentFragment();
        const lines = text.replace(/\r\n?/g, '\n').split('\n');

        lines.forEach(function(line, index) {
            if (index > 0) fragment.appendChild(document.createElement('br'));
            fragment.appendChild(document.createTextNode(line));
        });

        insertFragment(fragment);
    }

    function editorText() {
        let html = richEditor.innerHTML
            .replace(/<div[^>]*>/gi, '\n')
            .replace(/<br\s*\/?\s*>/gi, '\n')
            .replace(/<\/div>/gi, '');
        const holder = document.createElement('div');
        holder.innerHTML = html;
        return holder.textContent || holder.innerText || '';
    }

    function syncTextarea() {
        textarea.value = editorText();
    }

    function clearActiveCategory() {
        emojiCategories.forEach(function(button) {
            button.classList.remove('active');
        });
    }

    function setActiveCategory(category) {
        emojiCategories.forEach(function(button) {
            button.classList.toggle('active', button.dataset.category === category);
        });
    }

    function closePicker() {
        emojiPicker.style.display = 'none';
        emojiPicker.style.transform = '';
        emojiBtn.setAttribute('aria-expanded', 'false');
        clearActiveCategory();
    }

    function positionPicker() {
        if (emojiPicker.style.display === 'none') return;

        emojiPicker.style.transform = '';
        const pickerBox = emojiPicker.getBoundingClientRect();
        const buttonBox = emojiBtn.getBoundingClientRect();
        const edgeGap = 8;
        const spaceBelow = window.innerHeight - buttonBox.bottom - edgeGap;
        const spaceAbove = buttonBox.top - edgeGap;

        if (pickerBox.height > spaceBelow && spaceAbove > spaceBelow) {
            const targetTop = Math.max(edgeGap, buttonBox.top - pickerBox.height - edgeGap);
            const offset = Math.round(targetTop - pickerBox.top);
            emojiPicker.style.transform = 'translateY(' + offset + 'px)';
        }
    }

    function createEmojiOption(value, category) {
        const option = document.createElement('button');
        option.type = 'button';
        option.className = category === 'kaomoji'
            ? 'native-kaomoji-option'
            : 'native-emoji-option';
        option.textContent = value;
        option.title = '插入 ' + value;
        option.setAttribute('aria-label', '插入 ' + value);

        option.addEventListener('pointerdown', function(event) {
            event.preventDefault();
        });
        option.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            insertText(value);
            closePicker();
        });

        return option;
    }

    function loadEmojis(category) {
        emojiContainer.replaceChildren();
        (emojiData[category] || []).forEach(function(value) {
            emojiContainer.appendChild(createEmojiOption(value, category));
        });
    }

    function openPicker() {
        saveSelection();
        loadEmojis(lastActiveCategory);
        setActiveCategory(lastActiveCategory);
        emojiPicker.style.display = 'block';
        emojiBtn.setAttribute('aria-expanded', 'true');
        positionPicker();
    }

    function togglePicker() {
        if (emojiPicker.style.display === 'none') {
            openPicker();
        } else {
            closePicker();
        }
    }

    richEditor.addEventListener('input', syncTextarea);
    richEditor.addEventListener('keyup', saveSelection);
    richEditor.addEventListener('mouseup', saveSelection);
    richEditor.addEventListener('focus', saveSelection);
    richEditor.addEventListener('paste', function(event) {
        event.preventDefault();
        saveSelection();
        const text = (event.clipboardData || window.clipboardData).getData('text/plain');
        insertPlainText(text);
    });

    document.addEventListener('selectionchange', function() {
        const selection = window.getSelection();
        if (!selection || !selection.rangeCount) return;
        const range = selection.getRangeAt(0);
        if (selectionIsInsideEditor(range)) saveSelection();
    });

    emojiBtn.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        togglePicker();
    });
    emojiBtn.addEventListener('keydown', function(event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            togglePicker();
        }
    });

    emojiCategories.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            lastActiveCategory = button.dataset.category;
            loadEmojis(lastActiveCategory);
            setActiveCategory(lastActiveCategory);
        });
    });

    document.addEventListener('click', function(event) {
        if (!emojiPicker.contains(event.target) && event.target !== emojiBtn) {
            closePicker();
        }
    });
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closePicker();
    });
    window.addEventListener('resize', positionPicker);
    window.addEventListener('scroll', positionPicker, { passive: true });

    const commentForm = document.getElementById('comment-form');
    if (commentForm) commentForm.addEventListener('submit', syncTextarea);

    syncTextarea();
});
