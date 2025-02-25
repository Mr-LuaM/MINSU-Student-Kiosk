document.addEventListener("DOMContentLoaded", () => {
    console.log("edit-student.js loaded successfully");

    // Skill Management
    const skillsContainer = document.getElementById("skillsContainer");
    const addSkillBtn = document.getElementById("addSkill");

    if (addSkillBtn) {
        addSkillBtn.addEventListener("click", () => addEntry(skillsContainer, skillTemplate));
    }

    skillsContainer?.addEventListener("click", (event) => {
        if (event.target.closest(".remove-skill")) {
            const entry = event.target.closest(".skill-entry");
            const hr = entry.previousElementSibling; // Check for the <hr> before the entry
            entry.remove();
            if (hr && hr.tagName === "HR") hr.remove(); // Remove <hr> if it exists
            updateIndexes(skillsContainer);
        }
    });

    // Achievement Management
    const achievementsContainer = document.getElementById("achievementsContainer");
    const addAchievementBtn = document.getElementById("addAchievement");

    if (addAchievementBtn) {
        addAchievementBtn.addEventListener("click", () => addEntry(achievementsContainer, achievementTemplate));
    }

    achievementsContainer?.addEventListener("click", (event) => {
        if (event.target.closest(".remove-achievement")) {
            const entry = event.target.closest(".achievement-entry");
            const hr = entry.previousElementSibling; // Check for the <hr> before the entry
            entry.remove();
            if (hr && hr.tagName === "HR") hr.remove(); // Remove <hr> if it exists
            updateIndexes(achievementsContainer);
        }
    });
});

/**
 * Adds a new entry (Skill or Achievement).
 * @param {Element} container - The parent container for entries.
 * @param {function} templateFunction - Function to generate the new entry template.
 */
function addEntry(container, templateFunction) {
    const newIndex = container.children.length;
    const newEntry = `<hr class="border-t border-gray-300 my-4">` + templateFunction(newIndex);
    container.insertAdjacentHTML("beforeend", newEntry);
}

/**
 * Updates name attributes for dynamically added fields to keep proper indexing.
 * @param {Element} container - The parent container.
 */
function updateIndexes(container) {
    [...container.children].forEach((entry, index) => {
        if (entry.classList.contains("skill-entry") || entry.classList.contains("achievement-entry")) {
            entry.querySelectorAll("input, select").forEach((input) => {
                input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
            });
        }
    });
}

/**
 * Returns the HTML template for a new skill entry.
 * @param {number} index - The index for name attributes.
 */
const skillTemplate = (index) => `
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 skill-entry">
        <div>
            <label class="block text-sm font-semibold text-primary">Skill Name</label>
            <input type="text" name="skills[${index}][skill_name]" required
                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm" />
        </div>
        <div class="flex space-x-2">
            <div class="w-full">
                <label class="block text-sm font-semibold text-primary">Proficiency Level</label>
                <select name="skills[${index}][proficiency_level]" required
                    class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm">
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                    <option value="Expert">Expert</option>
                </select>
            </div>
            <button type="button"
                class="self-end bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 transition remove-skill">
                -
            </button>
        </div>
    </div>
`;

/**
 * Returns the HTML template for a new achievement entry.
 * @param {number} index - The index for name attributes.
 */
const achievementTemplate = (index) => `
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 achievement-entry">
        <div>
            <label class="block text-sm font-semibold text-primary">Achievement Name</label>
            <input type="text" name="achievements[${index}][achievement_name]" required
                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm" />
        </div>
        <div>
            <label class="block text-sm font-semibold text-primary">Category</label>
            <select name="achievements[${index}][category]" required
                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm">
                <option value="Academic">Academic</option>
                <option value="Sports">Sports</option>
                <option value="Arts">Arts</option>
                <option value="Technology">Technology</option>
                <option value="Community">Community</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-primary">Award Date</label>
            <input type="date" name="achievements[${index}][award_date]" required
                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm" />
        </div>
        <div>
            <label class="block text-sm font-semibold text-primary">Awarding Body</label>
            <input type="text" name="achievements[${index}][awarding_body]" required
                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm" />
        </div>
        <div class="flex items-end">
            <button type="button"
                class="self-end bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 transition remove-achievement">
                -
            </button>
        </div>
    </div>
`;
