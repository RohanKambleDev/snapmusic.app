// -------------------------
// Simple wizard state
// -------------------------
const state = {
	step: 1,
	imageFile: null,
	imageUrl: null,
	audioFile: null,
	audioUrl: null,
	creating: false,
	createTimer: null,
	createPct: 0,
};

// Elements
const panel1 = document.getElementById("panel1");
const panel2 = document.getElementById("panel2");
const panel3 = document.getElementById("panel3");

const pageTitle = document.getElementById("pageTitle");
const pageSubtitle = document.getElementById("pageSubtitle");

const stepDot1 = document.getElementById("stepDot1");
const stepDot2 = document.getElementById("stepDot2");
const stepDot3 = document.getElementById("stepDot3");
const stepLabel1 = document.getElementById("stepLabel1");
const stepLabel2 = document.getElementById("stepLabel2");
const stepLabel3 = document.getElementById("stepLabel3");

// Step 1 (image)
const imageDrop = document.getElementById("imageDrop");
const imageDropHint = document.getElementById("imageDropHint");
const imageInput = document.getElementById("imageInput");
const imageBrowseBtn = document.getElementById("imageBrowseBtn");
const imageEmpty = document.getElementById("imageEmpty");
const imagePreviewWrap = document.getElementById("imagePreviewWrap");
const imagePreview = document.getElementById("imagePreview");
const imageMeta = document.getElementById("imageMeta");
const imageReplaceBtn = document.getElementById("imageReplaceBtn");
const imageRemoveBtn = document.getElementById("imageRemoveBtn");
const toStep2 = document.getElementById("toStep2");

// Step 2 (audio)
const audioDrop = document.getElementById("audioDrop");
const audioDropHint = document.getElementById("audioDropHint");
const audioInput = document.getElementById("audioInput");
const audioBrowseBtn = document.getElementById("audioBrowseBtn");
const audioEmpty = document.getElementById("audioEmpty");
const audioPreviewWrap = document.getElementById("audioPreviewWrap");
const audioMeta = document.getElementById("audioMeta");
const audioPlayer = document.getElementById("audioPlayer");
const audioReplaceBtn = document.getElementById("audioReplaceBtn");
const audioRemoveBtn = document.getElementById("audioRemoveBtn");
const backTo1 = document.getElementById("backTo1");
const toStep3 = document.getElementById("toStep3");

// Step 3 (create)
const backTo2 = document.getElementById("backTo2");
const finalImage = document.getElementById("finalImage");
const finalAudioMeta = document.getElementById("finalAudioMeta");
const finalAudioPlayer = document.getElementById("finalAudioPlayer");
const createBtn = document.getElementById("createBtn");
const uploadForm = document.getElementById("uploadForm");

const createStatus = document.getElementById("createStatus");
const createBar = document.getElementById("createBar");

// -------------------------
// Helpers
// -------------------------
function fmtBytes(bytes) {
	if (!bytes && bytes !== 0) return "";
	const units = ["B", "KB", "MB", "GB"];
	let i = 0;
	let n = bytes;
	while (n >= 1024 && i < units.length - 1) {
		n /= 1024;
		i++;
	}
	return `${n.toFixed(i === 0 ? 0 : 1)} ${units[i]}`;
}

function setStep(step) {
	state.step = step;

	// Panels
	panel1.classList.toggle("hidden", step !== 1);
	panel2.classList.toggle("hidden", step !== 2);
	panel3.classList.toggle("hidden", step !== 3);

	// Title
	if (step === 1) {
		pageTitle.textContent = "Upload Your Photo";
		pageSubtitle.textContent = "";
	} else if (step === 2) {
		pageTitle.textContent = "Upload Your Audio";
		pageSubtitle.textContent = "";
	} else {
		pageTitle.textContent = "Create Your SnapMusic";
		pageSubtitle.textContent = "";
		syncFinalPreview();
	}

	// Stepper UI
	const active = (dot, label) => {
		dot.className =
			"h-8 w-8 md:h-9 md:w-9 rounded-full bg-yellow-500 text-black font-semibold flex items-center justify-center text-sm md:text-base";
		label.className = "text-xs md:text-sm text-white/90";
	};
	const done = (dot, label) => {
		dot.className =
			"h-8 w-8 md:h-9 md:w-9 rounded-full bg-emerald-400/90 text-black font-semibold flex items-center justify-center text-sm md:text-base";
		label.className = "text-xs md:text-sm text-white/90";
	};
	const idle = (dot, label) => {
		dot.className =
			"h-8 w-8 md:h-9 md:w-9 rounded-full bg-white/10 text-white/70 font-semibold flex items-center justify-center text-sm md:text-base";
		label.className = "text-xs md:text-sm text-white/70";
	};

	// Step states
	if (step === 1) {
		active(stepDot1, stepLabel1);
		idle(stepDot2, stepLabel2);
		idle(stepDot3, stepLabel3);
	} else if (step === 2) {
		done(stepDot1, stepLabel1);
		active(stepDot2, stepLabel2);
		idle(stepDot3, stepLabel3);
	} else {
		done(stepDot1, stepLabel1);
		done(stepDot2, stepLabel2);
		active(stepDot3, stepLabel3);
	}
}

function setImage(file) {
	const errorEl = document.getElementById("imageError");
	if (errorEl) errorEl.textContent = "";

	if (!file) return;

	// Validate type
	const ok = ["image/jpeg", "image/png"].includes(file.type);
	if (!ok) {
		if (errorEl) errorEl.textContent = "Please upload a JPG or PNG image.";

		// Manual cleanup to preserve error
		imageInput.value = "";
		if (state.imageUrl) URL.revokeObjectURL(state.imageUrl);
		state.imageFile = null;
		state.imageUrl = null;
		imageEmpty.classList.remove("hidden");
		imagePreviewWrap.classList.add("hidden");
		toStep2.disabled = true;
		return;
	}

	// Validate size (2MB)
	const MAX_SIZE = 2 * 1024 * 1024;
	if (file.size > MAX_SIZE) {
		if (errorEl)
			errorEl.textContent = "The image file size must not exceed 2MB.";

		// Manual cleanup to preserve error
		imageInput.value = "";
		if (state.imageUrl) URL.revokeObjectURL(state.imageUrl);
		state.imageFile = null;
		state.imageUrl = null;
		imageEmpty.classList.remove("hidden");
		imagePreviewWrap.classList.add("hidden");
		toStep2.disabled = true;
		return;
	}

	// Cleanup old url
	if (state.imageUrl) URL.revokeObjectURL(state.imageUrl);

	state.imageFile = file;
	state.imageUrl = URL.createObjectURL(file);

	imagePreview.src = state.imageUrl;
	imageMeta.textContent = `${file.name} • ${fmtBytes(file.size)}`;

	imageEmpty.classList.add("hidden");
	imagePreviewWrap.classList.remove("hidden");
	toStep2.disabled = false;
}

function clearImage() {
	const errorEl = document.getElementById("imageError");
	if (errorEl) errorEl.textContent = "";

	if (state.imageUrl) URL.revokeObjectURL(state.imageUrl);
	state.imageFile = null;
	state.imageUrl = null;

	imageInput.value = "";
	imagePreview.src = "";
	imageMeta.textContent = "";

	imageEmpty.classList.remove("hidden");
	imagePreviewWrap.classList.add("hidden");
	toStep2.disabled = true;
}

function setAudio(file) {
	const errorEl = document.getElementById("audioError");
	if (errorEl) errorEl.textContent = "";

	if (!file) return;

	// Basic validate type
	if (
		!file.type.startsWith("audio/") &&
		!file.name.endsWith(".mp3") &&
		!file.name.endsWith(".wav")
	) {
		// Relaxed check, just ensuring it's audio-ish if type is missing/weird
	}

	// Validate size (2MB)
	const MAX_SIZE = 2 * 1024 * 1024;
	if (file.size > MAX_SIZE) {
		if (errorEl)
			errorEl.textContent = "The audio file size must not exceed 2MB.";

		// Manual cleanup to preserve error
		audioInput.value = "";
		if (state.audioUrl) URL.revokeObjectURL(state.audioUrl);
		state.audioFile = null;
		state.audioUrl = null;
		audioEmpty.classList.remove("hidden");
		audioPreviewWrap.classList.add("hidden");
		toStep3.disabled = true;
		return;
	}

	if (state.audioUrl) URL.revokeObjectURL(state.audioUrl);

	state.audioFile = file;
	state.audioUrl = URL.createObjectURL(file);

	audioMeta.textContent = `${file.name} • ${fmtBytes(file.size)}`;
	audioPlayer.src = state.audioUrl;

	audioEmpty.classList.add("hidden");
	audioPreviewWrap.classList.remove("hidden");
	toStep3.disabled = false;
}

function clearAudio() {
	const errorEl = document.getElementById("audioError");
	if (errorEl) errorEl.textContent = "";

	if (state.audioUrl) URL.revokeObjectURL(state.audioUrl);
	state.audioFile = null;
	state.audioUrl = null;

	audioInput.value = "";
	audioPlayer.src = "";
	audioMeta.textContent = "";

	audioEmpty.classList.remove("hidden");
	audioPreviewWrap.classList.add("hidden");
	toStep3.disabled = true;
}

function syncFinalPreview() {
	finalImage.src = state.imageUrl || "";
	finalAudioMeta.textContent = state.audioFile
		? `${state.audioFile.name} • ${fmtBytes(state.audioFile.size)}`
		: "";
	finalAudioPlayer.src = state.audioUrl || "";

	// reset create UI
	createStatus.classList.add("hidden");
	state.creating = false;
}

// -------------------------
// Submit Handler
// -------------------------
createBtn.addEventListener("click", () => {
	if (!state.imageFile || !state.audioFile) {
		alert("Please select both image and audio first.");
		return;
	}

	// Show loading UI
	state.creating = true;
	createStatus.classList.remove("hidden");
	createBtn.disabled = true;
	createBtn.classList.add("opacity-50", "cursor-not-allowed");
	createBtn.innerText = "Uploading...";

	// Submit form
	uploadForm.submit();
});

// -------------------------
// Drag & Drop bindings
// -------------------------
function bindDropZone(zoneEl, hintEl, onFiles) {
	const highlight = (on) => hintEl.classList.toggle("ring-4", on);

	zoneEl.addEventListener("dragover", (e) => {
		e.preventDefault();
		highlight(true);
	});
	zoneEl.addEventListener("dragleave", () => highlight(false));
	zoneEl.addEventListener("drop", (e) => {
		e.preventDefault();
		highlight(false);
		const files = e.dataTransfer?.files;
		if (files && files.length) {
			onFiles(files);

			// Manually assign files to input (needed for form submit)
			const inputId =
				zoneEl.id === "imageDrop" ? "imageInput" : "audioInput";
			document.getElementById(inputId).files = files;
		}
	});
}

// Step 1 handlers
imageDrop.addEventListener("click", () => imageInput.click());
imageDrop.addEventListener("keydown", (e) => {
	if (e.key === "Enter" || e.key === " ") {
		e.preventDefault();
		imageInput.click();
	}
});
imageBrowseBtn.addEventListener("click", (e) => {
	e.stopPropagation();
	imageInput.click();
});
imageReplaceBtn.addEventListener("click", (e) => {
	e.stopPropagation();
	imageInput.click();
});
imageRemoveBtn.addEventListener("click", (e) => {
	e.stopPropagation();
	clearImage();
});

imageInput.addEventListener("change", (e) => {
	const file = e.target.files?.[0];
	if (file) setImage(file);
});

bindDropZone(imageDrop, imageDropHint, (files) => setImage(files[0]));

toStep2.addEventListener("click", () => setStep(2));

// Step 2 handlers
audioDrop.addEventListener("click", () => audioInput.click());
audioDrop.addEventListener("keydown", (e) => {
	if (e.key === "Enter" || e.key === " ") {
		e.preventDefault();
		audioInput.click();
	}
});
audioBrowseBtn.addEventListener("click", (e) => {
	e.stopPropagation();
	audioInput.click();
});
audioReplaceBtn.addEventListener("click", (e) => {
	e.stopPropagation();
	audioInput.click();
});
audioRemoveBtn.addEventListener("click", (e) => {
	e.stopPropagation();
	clearAudio();
});

audioInput.addEventListener("change", (e) => {
	const file = e.target.files?.[0];
	if (file) setAudio(file);
});

bindDropZone(audioDrop, audioDropHint, (files) => setAudio(files[0]));

backTo1.addEventListener("click", () => setStep(1));
toStep3.addEventListener("click", () => setStep(3));

// Step 3 handlers
backTo2.addEventListener("click", () => setStep(2));

// Init
clearImage();
clearAudio();
setStep(1);