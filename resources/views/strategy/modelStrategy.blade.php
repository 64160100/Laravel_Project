<style>
.modal-title-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.modal-title {
    margin-bottom: 0.25rem;
}

.modal-subtitle {
    margin-bottom: 0;
    font-size: 0.9rem;
    color: #6c757d;
}

.table-bordered th {
    text-align: center;
    vertical-align: middle;
    background-color: #f8f9fa;
}

.table-bordered td {
    vertical-align: top;
}

.table-bordered ul {
    padding-left: 20px;
    margin-bottom: 0;
}

.delete-item {
    color: red;
    cursor: pointer;
    margin-left: 5px;
}

.delete-list form button {
    display: none;
}
</style>

<link rel="stylesheet" href="{{ asset('css/viewStrategic.css') }}">
<div class="modal fade" id="strategicAnalysisModal" tabindex="-1" aria-labelledby="strategicAnalysisModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title-container">
                    <h5 class="modal-title" id="strategicAnalysisModalLabel">การวิเคราะห์บริบทเชิงกลยุทธ์</h5>
                    <p class="modal-subtitle">โอกาสเชิงกลยุทธ์ ความท้าทายเชิงกลยุทธ์ ความได้เปรียบเชิงกลยุทธ์</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn-add" data-bs-toggle="modal"
                    data-bs-target="#addStrategicOpportunityModal">
                    เพิ่มโอกาสเชิงกลยุทธ์ใหม่
                </button>
                <div class="d-flex justify-content-end mb-3">
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 14%;">หัวข้อ</th>
                            <th style="width: 30%;">โอกาสเชิงกลยุทธ์<br><small>(Strategic Opportunity)</small></th>
                            <th style="width: 30%;">ความท้าทายเชิงกลยุทธ์<br><small>(Strategic Challenges)</small></th>
                            <th style="width: 40%;">ความได้เปรียบเชิงกลยุทธ์<br><small>(Strategic Advantages)</small>
                            </th>
                            <th style="width: 1%;">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($strategicOpportunities as $opportunity)
                        <tr>
                            <td>{{ $opportunity->Name_Strategic_Opportunity }}</td>
                            <td>
                                <ul class="delete-list" data-type="details">
                                    @foreach($opportunity->details as $detail)
                                    <li>
                                        {{ $detail->Details_Strategic_Opportunity }}
                                        <button type="button" class="btn btn-link text-primary p-0 m-0 edit-detail"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editDetailModal{{ $detail->Id_Strategic_Opportunity_Details }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form
                                            action="{{ route('StrategicAnalysis.destroyDetail', ['type' => 'details', 'id' => $detail->Id_Strategic_Opportunity_Details]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="opportunity_id"
                                                value="{{ $opportunity->Id_Strategic_Opportunity }}">
                                            <button type="submit" class="btn btn-link text-danger p-0 m-0"
                                                onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบรายการนี้?')">&#x2715;</button>
                                        </form>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul class="delete-list" data-type="challenges">
                                    @foreach($opportunity->challenges as $challenge)
                                    <li>
                                        {{ $challenge->Details_Strategic_Challenges }}
                                        <button type="button" class="btn btn-link text-primary p-0 m-0 edit-challenge"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editChallengeModal{{ $challenge->Id_Strategic_Challenges }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form
                                            action="{{ route('StrategicAnalysis.destroyDetail', ['type' => 'challenges', 'id' => $challenge->Id_Strategic_Challenges]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="opportunity_id"
                                                value="{{ $opportunity->Id_Strategic_Opportunity }}">
                                            <button type="submit" class="btn btn-link text-danger p-0 m-0"
                                                onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบรายการนี้?')">&#x2715;</button>
                                        </form>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul class="delete-list" data-type="advantages">
                                    @foreach($opportunity->advantages as $advantage)
                                    <li>
                                        {{ $advantage->Details_Strategic_Advantages }}
                                        <button type="button" class="btn btn-link text-primary p-0 m-0 edit-advantage"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editAdvantageModal{{ $advantage->Id_Strategic_Advantages }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form
                                            action="{{ route('StrategicAnalysis.destroyDetail', ['type' => 'advantages', 'id' => $advantage->Id_Strategic_Advantages]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="opportunity_id"
                                                value="{{ $opportunity->Id_Strategic_Opportunity }}">
                                            <button type="submit" class="btn btn-link text-danger p-0 m-0"
                                                onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบรายการนี้?')">&#x2715;</button>
                                        </form>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm mx-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addStrategicAnalysisModal{{ $opportunity->Id_Strategic_Opportunity }}">
                                        <i class="fas fa-plus"></i> เพิ่ม
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm mx-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editStrategicAnalysisModal{{ $opportunity->Id_Strategic_Opportunity }}">
                                        <i class="fas fa-edit"></i> แก้ไข
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm mx-1 toggle-delete-mode">
                                        <i class="fas fa-trash"></i> <span class="delete-text">ลบ</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($strategicOpportunities as $opportunity)
<div class="modal fade" id="addStrategicAnalysisModal{{ $opportunity->Id_Strategic_Opportunity }}" tabindex="-1"
    aria-labelledby="addStrategicAnalysisModalLabel{{ $opportunity->Id_Strategic_Opportunity }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStrategicAnalysisModalLabel{{ $opportunity->Id_Strategic_Opportunity }}">
                    เพิ่มการวิเคราะห์เชิงกลยุทธ์ใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('StrategicAnalysis.addDetail') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Name_Strategic_Opportunity" class="form-label">ชื่อโอกาสเชิงกลยุทธ์</label>
                        <input type="text" class="form-control" id="Name_Strategic_Opportunity"
                            name="Name_Strategic_Opportunity" value="{{ $opportunity->Name_Strategic_Opportunity }}"
                            required>
                    </div>
                    <input type="hidden" name="Strategic_Id"
                        value="{{ $opportunity->Strategic_Id}}">

                    <div class="mb-3">
                        <label for="details" class="form-label">โอกาสเชิงกลยุทธ์</label>
                        <div id="detailsContainer{{ $opportunity->Id_Strategic_Opportunity }}">
                            <textarea class="form-control mb-2" name="details[]" rows="2"></textarea>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="addTextarea('detailsContainer{{ $opportunity->Id_Strategic_Opportunity }}', 'details[]')">เพิ่มข้อความ</button>
                    </div>
                    <div class="mb-3">
                        <label for="challenges" class="form-label">ความท้าทายเชิงกลยุทธ์</label>
                        <div id="challengesContainer{{ $opportunity->Id_Strategic_Opportunity }}">
                            <textarea class="form-control mb-2" name="challenges[]" rows="2"></textarea>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="addTextarea('challengesContainer{{ $opportunity->Id_Strategic_Opportunity }}', 'challenges[]')">เพิ่มข้อความ</button>
                    </div>
                    <div class="mb-3">
                        <label for="advantages" class="form-label">ความได้เปรียบเชิงกลยุทธ์</label>
                        <div id="advantagesContainer{{ $opportunity->Id_Strategic_Opportunity }}">
                            <textarea class="form-control mb-2" name="advantages[]" rows="2"></textarea>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="addTextarea('advantagesContainer{{ $opportunity->Id_Strategic_Opportunity }}', 'advantages[]')">เพิ่มข้อความ</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Edit Strategic Analysis Modals -->
@foreach($strategicOpportunities as $opportunity)
<div class="modal fade" id="editStrategicAnalysisModal{{ $opportunity->Id_Strategic_Opportunity }}" tabindex="-1"
    aria-labelledby="editStrategicAnalysisModalLabel{{ $opportunity->Id_Strategic_Opportunity }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="editStrategicAnalysisModalLabel{{ $opportunity->Id_Strategic_Opportunity }}">
                    แก้ไขการวิเคราะห์เชิงกลยุทธ์
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ route('StrategicAnalysis.updateDetail', ['type' => 'opportunity', 'id' => $opportunity->Id_Strategic_Opportunity]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Name_Strategic_Opportunity" class="form-label">ชื่อโอกาสเชิงกลยุทธ์</label>
                        <input type="text" class="form-control" id="Name_Strategic_Opportunity"
                            name="Name_Strategic_Opportunity" value="{{ $opportunity->Name_Strategic_Opportunity }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">รายละเอียด</label>
                        <div class="form-group">
                            <label class="form-label">โอกาสเชิงกลยุทธ์</label>
                            @foreach($opportunity->details as $detail)
                            <textarea class="form-control mb-2"
                                id="details{{ $detail->Id_Strategic_Opportunity_Details }}"
                                name="details[{{ $detail->Id_Strategic_Opportunity_Details }}]" rows="1"
                                style="height: auto; overflow-y: auto; resize: none;"
                                onfocus="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                                oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'">{{ $detail->Details_Strategic_Opportunity }}</textarea>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label class="form-label">ความท้าทายเชิงกลยุทธ์</label>
                            @foreach($opportunity->challenges as $challenge)
                            <textarea class="form-control mb-2" id="challenges{{ $challenge->Id_Strategic_Challenge }}"
                                name="challenges[{{ $challenge->Id_Strategic_Challenge }}]" rows="1"
                                style="height: auto; overflow-y: auto; resize: none;"
                                onfocus="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                                oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'">{{ $challenge->Details_Strategic_Challenges }}</textarea>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label class="form-label">ความได้เปรียบเชิงกลยุทธ์</label>
                            @foreach($opportunity->advantages as $advantage)
                            <textarea class="form-control mb-2" id="advantages{{ $advantage->Id_Strategic_Advantage }}"
                                name="advantages[{{ $advantage->Id_Strategic_Advantage }}]" rows="1"
                                style="height: auto; overflow-y: auto; resize: none;"
                                onfocus="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                                oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'">{{ $advantage->Details_Strategic_Advantages }}</textarea>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
    function addTextarea(containerId, name) {
        const container = document.getElementById(containerId);
        const textareaDiv = document.createElement('div');
        textareaDiv.classList.add('mb-2', 'd-flex', 'align-items-center');

        const textarea = document.createElement('textarea');
        textarea.classList.add('form-control', 'me-2');
        textarea.name = name;
        textarea.rows = 2;

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('btn', 'btn-outline-danger', 'btn-sm');
        removeButton.innerText = 'ลบ';
        removeButton.onclick = function() {
            container.removeChild(textareaDiv);
        };

        textareaDiv.appendChild(textarea);
        textareaDiv.appendChild(removeButton);
        container.appendChild(textareaDiv);
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const strategicTypeSelect = document.getElementById('strategic_type');
    const opportunityFields = document.getElementById('opportunityFields');
    const challengeFields = document.getElementById('challengeFields');
    const advantageFields = document.getElementById('advantageFields');

    strategicTypeSelect.addEventListener('change', function() {
        opportunityFields.style.display = 'none';
        challengeFields.style.display = 'none';
        advantageFields.style.display = 'none';

        switch (this.value) {
            case 'opportunity':
                opportunityFields.style.display = 'block';
                break;
            case 'challenge':
                challengeFields.style.display = 'block';
                break;
            case 'advantage':
                advantageFields.style.display = 'block';
                break;
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.toggle-delete-mode');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const deleteForms = row.querySelectorAll('.delete-list form');
            const deleteText = this.querySelector('.delete-text');

            deleteForms.forEach(form => {
                const deleteButton = form.querySelector('button');
                if (deleteButton.style.display === 'none' || deleteButton.style
                    .display === '') {
                    deleteButton.style.display = 'inline-block';
                    deleteText.textContent = 'ยกเลิก';
                } else {
                    deleteButton.style.display = 'none';
                    deleteText.textContent = 'ลบ';
                }
            });
        });
    });

    // ซ่อนปุ่มลบทั้งหมดเมื่อโหลดหน้า
    const allDeleteButtons = document.querySelectorAll('.delete-list form button');
    allDeleteButtons.forEach(button => {
        button.style.display = 'none';
    });
});
</script>

<!-- Modal Structure -->
<div class="modal fade" id="addStrategicOpportunityModal" tabindex="-1"
    aria-labelledby="addStrategicOpportunityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStrategicOpportunityModalLabel">เพิ่มโอกาสเชิงกลยุทธ์ใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('StrategicOpportunity.addOpportunity') }}" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" id="Strategic_Id" name="Strategic_Id" readonly required>
                    <div class="mb-3">
                        <label for="Name_Strategic_Opportunity" class="form-label">ชื่อโอกาสเชิงกลยุทธ์</label>
                        <input type="text" class="form-control" id="Name_Strategic_Opportunity" name="Name_Strategic_Opportunity" required>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParts = window.location.pathname.split('/');
    const strategicId = urlParts[urlParts.length - 1];

    const strategicIdInput = document.getElementById('Strategic_Id');
    if (strategicIdInput) {
        strategicIdInput.value = strategicId;
    }
});
</script>
