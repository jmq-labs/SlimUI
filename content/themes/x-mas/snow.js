
var canvas = document.getElementById("RENDERS");
var ctx = canvas.getContext("2d");
var particles = [];
var angle = 0;
var W; var H;
var mp = 25; 
  
function updateCanvas(){  
  W = window.innerWidth;
  H = window.innerHeight;
  canvas.width = W;
  canvas.height = H;
  
  for(var i = 0; i < mp; i++)
  	{
  		particles.push({
  			x: Math.random()*W, 
  			y: Math.random()*H, 
  			r: Math.random()*4+1,
  			d: Math.random()*mp
  		})
  	}
}
	
function draw(){
	var grad = ctx.createLinearGradient(0,0,0,H);
    grad.addColorStop(0, "#00668B");
    grad.addColorStop(1, "#fff");
	ctx.fillStyle = grad;
    ctx.beginPath();
	ctx.rect(0,0,W,H);
	ctx.clearRect(0, 0, W, H);	
	ctx.closePath();
	ctx.fill();
	
	ctx.beginPath();
	for(var i = 0; i < mp; i++)
	{
		var p = particles[i];
		
      	ctx.fillStyle = 'white';
		ctx.moveTo(p.x, p.y);
		ctx.arc(p.x, p.y, p.r, 0, Math.PI*2, true);
	}   
	ctx.closePath();
	ctx.fill();
	update();
}

function update()
{
	angle += 0.01;
	for(var i = 0; i < mp; i++)
	{
		var p = particles[i];
		p.y += Math.cos(angle+p.d) + 1 + p.r/2;
		p.x += Math.sin(angle) * 2;
		if(p.x > W+5 || p.x < -5 || p.y > H)
		{
			if(i%3 > 0)
			{
				particles[i] = {x: Math.random()*W, y: -10, r: p.r, d: p.d};
			}
			else
			{				
				if(Math.sin(angle) > 0)
				{					
					particles[i] = {x: -5, y: Math.random()*H, r: p.r, d: p.d};
				}
				else
				{					
					particles[i] = {x: W+5, y: Math.random()*H, r: p.r, d: p.d};
				}
			}
		}
	}
}
updateCanvas();
setInterval(draw, 33);
window.addEventListener("resize", updateCanvas);