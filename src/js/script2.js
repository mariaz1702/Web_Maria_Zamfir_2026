const c = document.getElementById("travelCanvas");
const ctx = c.getContext("2d");
ctx.fillStyle = "#87CEEB"; ctx.fillRect(0,0,300,200); // Sky
ctx.fillStyle = "#228B22"; ctx.beginPath(); ctx.moveTo(0,200); ctx.lineTo(150,50); ctx.lineTo(300,200); ctx.fill(); // Mountain