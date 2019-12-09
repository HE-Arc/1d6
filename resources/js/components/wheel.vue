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

let playingAnimation = true;
let tick = 0;
let acceleration = 0;
let speed = 0;
let currentAngle = 0;
let findCorrectSlowDown = false;
let ticksToStopTheWheel = -1;
let targetWeight = 0;

// Get a center point and a radius for a given canvas. Circle will fit in the center of the canvas
function getCircle(canvas) {
  return {
    x: canvas.width / 2,
    y: canvas.height / 2,
    r: canvas.width / 2 - 2
  };
}

function spin(targetWeight_) {
  previsionalDistTraveled = -1;
  targetWeight = targetWeight_;
  acceleration = 0.005;
  findCorrectSlowDown = false;

  setTimeout(() => {
    acceleration = 0;
    findCorrectSlowDown = true;
  }, 1000);
}

window.spin = spin;
// Draw a part of a pie
function drawPiePart(canvas, ctx, c, start, size, color, radius, lineWidth) {
  // Where we start / end the pie angle
  start = start * 2 * Math.PI;
  let end = start + size * 2 * Math.PI;

  // We use a trick to render nice "parts" by using a large line width
  ctx.lineWidth = lineWidth;
  ctx.strokeStyle = color;
  ctx.beginPath();
  ctx.arc(0, 0, radius, start, end);
  ctx.stroke();
}

let previsionalDistTraveled = -1;
function handleCurrentAngle() {
  if (ticksToStopTheWheel >= 0) {
    ticksToStopTheWheel--;
  } else if (ticksToStopTheWheel > -1) {
    ticksToStopTheWheel--;
    speed = 0;
    acceleration = 0;
  }

  speed += acceleration;
  currentAngle += speed;

  if (findCorrectSlowDown) {
    const slowDownAcceleration = -0.001;
    // Time in ticks to reach 0
    let tempTicks = speed / -slowDownAcceleration;

    let distTraveled = 0;
    let tempCurrentSpeed = speed;

    // Compute this only once because the speed does not change
    if (previsionalDistTraveled === -1) {
      // "Quickly" compute how much we will travel with a speed of -0.001
      for (let i = 0; i < tempTicks; i++) {
        tempCurrentSpeed += slowDownAcceleration;
        distTraveled += tempCurrentSpeed;
      }

      previsionalDistTraveled = distTraveled;
    }

    const stopAngle = (/*0.5 * Math.PI + */currentAngle + previsionalDistTraveled) % (2 * Math.PI);

    const targetWeightInRadian = 2 * Math.PI * targetWeight;
    const angleDiff = Math.abs(targetWeightInRadian - stopAngle);

    // Assume 1 deg is enough precision
    if (angleDiff <= 0.017) {
      findCorrectSlowDown = false;
      acceleration = slowDownAcceleration;
      ticksToStopTheWheel = tempTicks;
    }
  }
}

// Main render "loop"
function render(ctx, canvas, items) {
  const c = getCircle(canvas);

  handleCurrentAngle();

  renderBackground(ctx, canvas, c);
  renderItems(ctx, canvas, c, items);

  ctx.fillStyle = "white";
  ctx.fillRect(0, 0, 100, 150);
  ctx.fillStyle = "black";
  ctx.fillText(currentAngle % (2 * Math.PI), 100, 100);

  // Saves battery on mobile by only rendering when we need it
  if (playingAnimation) {
    requestAnimationFrame(() => {
      render(ctx, canvas, items);
    });
  }
}

function toRad(x) {
  return x * 2 * Math.PI;
}

// Render all items present in the pie. Weights must sum up to 1!
function renderItems(ctx, canvas, c, items) {
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
      canvas,
      ctx,
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
  //ctx.translate(0,0);
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
  //ctx.translate(-c.x, -c.y);
}

function renderBackground(ctx, canvas, c) {
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
    const canvas = document.getElementById("wheel-canvas");
    const ctx = canvas.getContext("2d");

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