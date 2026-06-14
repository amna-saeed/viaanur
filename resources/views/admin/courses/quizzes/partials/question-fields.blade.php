@php
    $questions = $questions ?? old('questions', [['question_text' => '', 'option_a' => '', 'option_b' => '', 'option_c' => '', 'option_d' => '', 'correct_option' => 'a', 'marks' => 1]]);
    if (empty($questions)) {
        $questions = [['question_text' => '', 'option_a' => '', 'option_b' => '', 'option_c' => '', 'option_d' => '', 'correct_option' => 'a', 'marks' => 1]];
    }
@endphp

<div id="quiz-questions-wrap">
    @foreach($questions as $i => $q)
        <div class="card mb-3 quiz-question-block" data-index="{{ $i }}">
            <div class="card-header d-flex justify-content-between align-items-center py-2">
                <strong>Question <span class="quiz-question-num">{{ $loop->iteration }}</span></strong>
                @if($loop->iteration > 1)
                    <button type="button" class="btn btn-sm btn-outline-danger quiz-remove-question">Remove</button>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Question text *</label>
                    <textarea class="form-control" name="questions[{{ $i }}][question_text]" rows="2" required>{{ $q['question_text'] ?? '' }}</textarea>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Option A *</label>
                        <input type="text" class="form-control" name="questions[{{ $i }}][option_a]" required value="{{ $q['option_a'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Option B *</label>
                        <input type="text" class="form-control" name="questions[{{ $i }}][option_b]" required value="{{ $q['option_b'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Option C</label>
                        <input type="text" class="form-control" name="questions[{{ $i }}][option_c]" value="{{ $q['option_c'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Option D</label>
                        <input type="text" class="form-control" name="questions[{{ $i }}][option_d]" value="{{ $q['option_d'] ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Correct answer *</label>
                        <select class="form-control" name="questions[{{ $i }}][correct_option]" required>
                            @foreach(['a','b','c','d'] as $opt)
                                <option value="{{ $opt }}" {{ ($q['correct_option'] ?? 'a') === $opt ? 'selected' : '' }}>{{ strtoupper($opt) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marks *</label>
                        <input type="number" class="form-control" name="questions[{{ $i }}][marks]" min="1" required value="{{ $q['marks'] ?? 1 }}">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<button type="button" class="btn btn-outline-primary btn-sm mb-3" id="quiz-add-question">
    <i class="bi bi-plus-lg"></i> Add another question
</button>

@once
@push('scripts')
<script>
(function () {
    var wrap = document.getElementById('quiz-questions-wrap');
    var addBtn = document.getElementById('quiz-add-question');
    if (!wrap || !addBtn) return;

    function renumber() {
        wrap.querySelectorAll('.quiz-question-block').forEach(function (block, idx) {
            block.querySelector('.quiz-question-num').textContent = idx + 1;
        });
    }

    addBtn.addEventListener('click', function () {
        var blocks = wrap.querySelectorAll('.quiz-question-block');
        var i = blocks.length;
        var tpl = blocks[0].cloneNode(true);
        tpl.dataset.index = i;
        tpl.querySelectorAll('[name]').forEach(function (el) {
            el.name = el.name.replace(/questions\[\d+\]/, 'questions[' + i + ']');
            if (el.tagName === 'TEXTAREA' || el.tagName === 'SELECT') {
                el.value = el.tagName === 'SELECT' ? 'a' : '';
            } else {
                el.value = el.type === 'number' ? '1' : '';
            }
        });
        var removeBtn = tpl.querySelector('.quiz-remove-question');
        if (!removeBtn) {
            var head = tpl.querySelector('.card-header');
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-sm btn-outline-danger quiz-remove-question';
            btn.textContent = 'Remove';
            head.appendChild(btn);
        }
        wrap.appendChild(tpl);
        renumber();
    });

    wrap.addEventListener('click', function (e) {
        if (!e.target.classList.contains('quiz-remove-question')) return;
        var block = e.target.closest('.quiz-question-block');
        if (wrap.querySelectorAll('.quiz-question-block').length <= 1) return;
        block.remove();
        wrap.querySelectorAll('.quiz-question-block').forEach(function (b, idx) {
            b.dataset.index = idx;
            b.querySelectorAll('[name]').forEach(function (el) {
                el.name = el.name.replace(/questions\[\d+\]/, 'questions[' + idx + ']');
            });
        });
        renumber();
    });
})();
</script>
@endpush
@endonce
