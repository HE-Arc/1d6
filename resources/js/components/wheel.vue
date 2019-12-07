<template>
  <canvas id="wheel-canvas"></canvas>
</template>
<script>
export default {
  mounted() {
    const canvas = document.getElementById("wheel-canvas");
    const ctx = canvas.getContext("2d");

    const tempPercentages = [0.05, 0.1, 0.1, 0.4, 0.05, 0.3];

    canvas.width = canvas.offsetWidth;
    // Make sure canvas is a square
    canvas.height = canvas.width;

    const c = getCircle(canvas);

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

    ctx.lineWidth = c.r / 2;

    let sum = 0;
    for (let i = 0; i < tempPercentages.length; i++) {
      const p = tempPercentages[i];
      // TODO: Better random color / use names!
      drawPiePart(
        canvas,
        ctx,
        sum,
        p,
        ["#fefefe", "#f14668", "#00d1b2", "#3273dc", "#3298dc", "#48c774"][
          i % 6
        ]
      );
      sum += p;
    }

    // Needle selector
    // drawPiePart(canvas, ctx, 0.15, 0.01, "rgba(0, 0, 0, 0.8)");
  }
};

function getCircle(canvas) {
  return {
    x: canvas.width / 2,
    y: canvas.height / 2,
    r: canvas.width / 2 - 2
  };
}

function drawPiePart(canvas, ctx, start, size, color) {
  const c = getCircle(canvas);
  const margin = 0.01;

  start = start * 2 * Math.PI;
  let end = start + size * 2 * Math.PI;

  ctx.lineWidth = c.r / 2;
  ctx.strokeStyle = color;
  ctx.beginPath();
  ctx.arc(c.x, c.y, c.r * 0.75, start, end);
  ctx.stroke();
}
</script>

<style scoped>
#wheel-canvas {
  display: inline-block;
  width: 100%;
  max-width: 400px;
}
</style>