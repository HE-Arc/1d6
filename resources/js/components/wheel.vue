<template>
  <canvas id="wheel-canvas"></canvas>
</template>
<script>
// List of colors that will be available in the canvas
const colors = [
  "#fefefe",
  "#f14668",
  "#00d1b2",
  "#3273dc",
  "#3298dc",
  "#48c774"
];

const ROTATION_COUNT = 30;
const DECELERATION_COEFF = 0.01;

let duration = 0;
let currentAngle = Math.PI * 0.5;
let targetAngle = Math.PI * 0.5;
let ctx, canvas;
let items = [];

// Get a center point and a radius for a given canvas. Circle will fit in the center of the canvas
function getCircle() {
  return {
    x: canvas.width / 2,
    y: canvas.height / 2,
    r: canvas.width / 2 - 2
  };
}

// Start spinning the wheel
function spin(targetWeight) {
  targetAngle = toRad(0.75 - targetWeight + ROTATION_COUNT);
  currentAngle = Math.PI * 0.5;
  render();
}

// Calculate where the wheel should stop
function handleWheelRotation() {
  let t = (currentAngle + 1) / targetAngle;
  currentAngle += DECELERATION_COEFF * t * (3 - 2 * t) * (targetAngle - currentAngle); //(t * t * (3 - 2 * t)) * targetAngle;

  return targetAngle !== currentAngle;
}

// Draw a part of a pie
function drawPiePart(c, start, size, color, radius, lineWidth) {
  // Where we start / end the pie angle
  start = toRad(start);
  let end = start + toRad(size);

  // We use a trick to render nice "parts" by using a large line width
  ctx.lineWidth = lineWidth;
  ctx.strokeStyle = color;
  ctx.beginPath();
  ctx.arc(0, 0, radius, start, end);
  ctx.stroke();
}

// Main render "loop"
function render() {
  const c = getCircle();

  renderBackground(c);
  renderItems(c);

  // Saves battery on mobile by only rendering when we need it
  if (handleWheelRotation()) {
    requestAnimationFrame(() => {
      render();
    });
  }
}

function toRad(x) {
  return x * 2 * Math.PI;
}

// Render all items present in the pie. Weights must sum up to 1!
function renderItems(c) {
  let sum = 0;

  ctx.textBaseline = "middle";
  ctx.textAlign = "center";

  ctx.save();
  ctx.translate(c.x, c.y);
  ctx.rotate(currentAngle);

  let currentItemText = "";
  let currentItemColor = "";

  for (let i = 0; i < items.length; i++) {
    const item = items[i];

    // Pie parts
    drawPiePart(
      c,
      sum,
      item.weight,
      colors[i % colors.length],
      c.r * 0.75,
      c.r * 0.5
    );

    const angleInWeight =
      1 - ((currentAngle + Math.PI * 0.5) % (2 * Math.PI)) / (2 * Math.PI);
    if (angleInWeight > sum && angleInWeight <= sum + item.weight) {
      currentItemText = item.name;
      currentItemColor = colors[i % colors.length];
    }

    sum += item.weight;

    drawPiePartText(ctx, c, sum, item);
  }

  ctx.restore();

  ctx.fillStyle = currentItemColor;
  ctx.beginPath();
  let y = c.y - c.r * 0.5 + 5;
  ctx.moveTo(c.x, y);
  ctx.lineTo(c.x + 10, y + 25);
  ctx.lineTo(c.x - 10, y + 25);
  ctx.closePath();
  ctx.fill();

  ctx.fillStyle = "black";

  // Make sure we're not writing too big
  let fontSize = 20;
  if (ctx.measureText(currentItemText).width > c.r) {
    fontSize = 14;
  }

  ctx.font = fontSize + "px Helvetica, Arial, sans-serif";
  ctx.fillText(currentItemText, c.x, c.y, c.r - 10);
}

function drawPiePartText(ctx, c, sum, item) {
  ctx.rotate(toRad(sum - item.weight / 2));

  ctx.fillStyle = "black";

  // Make sure we're not writing too big
  let fontSize = 18;
  if (ctx.measureText(item.name).width > c.r * 0.5) {
    fontSize = 14;
  }

  ctx.font = fontSize + "px Helvetica,Arial,sans-serif";
  ctx.fillText(item.name, c.r * 0.75, 0, c.r * 0.5 - 5);

  ctx.rotate(-toRad(sum - item.weight / 2));
}

function renderBackground(c) {
  // Background
  ctx.fillStyle = "#eee";
  ctx.beginPath();
  ctx.arc(c.x, c.y, c.r, 0, 2 * Math.PI);
  ctx.fill();

  // Border
  ctx.lineWidth = 2;
  ctx.strokeStyle = "#aaa";
  ctx.beginPath();
  ctx.arc(c.x, c.y, c.r, 0, 2 * Math.PI);
  ctx.stroke();
}

export default {
  mounted() {
    canvas = document.getElementById("wheel-canvas");
    ctx = canvas.getContext("2d");

    // Make sure canvas is a square
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.width;

    render(ctx, canvas, [
      { name: "King Food", weight: 0.05 }, // < 0.05
      { name: "Coop", weight: 0.1 }, // < 0.15
      { name: "Piadina", weight: 0.1 }, // 0.25
      { name: "EatEco - Best burgers in Neuchatel", weight: 0.4 }, // < 0.65
      { name: "Mc Donalds", weight: 0.05 }, // < 0.7
      { name: "Paprika", weight: 0.3 } // < 1.0
    ]);
  }
};
</script>

<style scoped>
#wheel-canvas {
  display: inline-block;
  width: 100%;
  max-width: 400px;
}
</style>