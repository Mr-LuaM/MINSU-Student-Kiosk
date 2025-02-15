document.addEventListener("DOMContentLoaded", () => {
    console.log("edit-student.js loaded successfully");

    // Skill Management
    const skillsContainer = document.getElementById("skillsContainer");
    const addSkillBtn = document.getElementById("addSkill");

    if (addSkillBtn) {
        addSkillBtn.addEventListener("click", () => addEntry(skillsContainer, "skills", skillTemplate));
    }

    skillsContainer?.addEventListener("click", (event) => {
        if (event.target.closest(".remove-skill")) {
            event.target.closest(".skill-entry").remove();
            updateIndexes(skillsContainer, "skills");
        }
    });

    // Achievement Management
    const achievementsContainer = document.getElementById("achievementsContainer");
    const addAchievementBtn = document.getElementById("addAchievement");

    if (addAchievementBtn) {
        addAchievementBtn.addEventListener("click", () => addEntry(achievementsContainer, "achievements", achievementTemplate));
    }

    achievementsContainer?.addEventListener("click", (event) => {
        if (event.target.closest(".remove-achievement")) {
            event.target.closest(".achievement-entry").remove();
            updateIndexes(achievementsContainer, "achievements");
        }
    });
});

/**
 * Adds a new entry (Skill or Achievement).
 * @param {Element} container - The parent container for entries.
 * @param {string} type - The input field group name (skills/achievements).
 * @param {function} templateFunction - Function to generate the new entry template.
 */
function addEntry(container, type, templateFunction) {
    const newIndex = container.children.length;
    const newEntry = templateFunction(newIndex);
    container.insertAdjacentHTML("beforeend", newEntry);
}

/**
 * Updates name attributes for dynamically added fields to keep proper indexing.
 * @param {Element} container - The parent container.
 * @param {string} type - The input field group name (skills/achievements).
 */
function updateIndexes(container, type) {
    [...container.children].forEach((entry, index) => {
        entry.querySelectorAll("input, select").forEach((input) => {
            input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
        });
    });
}

/**
 * Returns the HTML template for a new skill entry.
 * @param {number} index - The index for name attributes.
 */
const skillTemplate = (index) => `
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 skill-entry">
        <div>
            <label class="block text-sm font-medium text-gray-700">Skill Name</label>
            <input type="text" name="skills[${index}][skill_name]"
                class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2" />
        </div>
        <div class="flex space-x-2">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Proficiency Level</label>
                <select name="skills[${index}][proficiency_level]"
                    class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2">
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                    <option value="Expert">Expert</option>
                </select>
            </div>
            <button type="button"
                class="self-end bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 remove-skill">
                ➖
            </button>
        </div>
    </div>
`;

/**
 * Returns the HTML template for a new achievement entry.
 * @param {number} index - The index for name attributes.
 */
const achievementTemplate = (index) => `
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 achievement-entry">
        <div>
            <label class="block text-sm font-medium text-gray-700">Achievement Name</label>
            <input type="text" name="achievements[${index}][achievement_name]"
                class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select name="achievements[${index}][category]"
                class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2">
                <option value="Academic">Academic</option>
                <option value="Sports">Sports</option>
                <option value="Arts">Arts</option>
                <option value="Technology">Technology</option>
                <option value="Community">Community</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Award Date</label>
            <input type="date" name="achievements[${index}][award_date]"
                class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2" />
        </div>
        <div class="flex space-x-2">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Awarding Body</label>
                <input type="text" name="achievements[${index}][awarding_body]"
                    class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2" />
            </div>
            <button type="button"
                class="self-end bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 remove-achievement">
                ➖
            </button>
        </div>
    </div>
`;
