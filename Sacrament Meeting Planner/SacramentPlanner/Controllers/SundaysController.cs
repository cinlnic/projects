using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using SacramentPlanner.Models;

namespace SacramentPlanner.Controllers
{
    public class SundaysController : Controller
    {
        private readonly SacramentPlannerContext _context;

        public SundaysController(SacramentPlannerContext context)
        {
            _context = context;
        }

        // GET: Sundays
        public async Task<IActionResult> Index(string sortOrder, string currentFilter, string searchString, int? pageNumber)
        {
            ViewData["CurrentSort"] = sortOrder;
            ViewData["NameSortParm"] = String.IsNullOrEmpty(sortOrder) ? "name_desc" : "";
            ViewData["DateSortParm"] = sortOrder == "Date" ? "date_desc" : "Date";
            int pageSize = 3;

            if (searchString != null)
            {
                pageNumber = 1;
            }
            else
            {
                searchString = currentFilter;
            }

            ViewData["CurrentFilter"] = searchString;
            var sundays = from m in _context.Sunday
                           select m;

            if (!String.IsNullOrEmpty(searchString))
            {
                sundays = sundays.Where(s => s.Conductor.Contains(searchString));
            }

            switch (sortOrder)
            {
                case "name_desc":
                    sundays = sundays.OrderByDescending(s => s.Conductor);
                    break;
                case "Date":
                    sundays = sundays.OrderBy(s => s.Date);
                    break;
                case "date_desc":
                    sundays = sundays.OrderByDescending(s => s.Date);
                    break;
                default:
                    sundays = sundays.OrderBy(s => s.Conductor);
                    break;
            }

            return View(await PaginatedList<Sunday>.CreateAsync(sundays.AsNoTracking(), pageNumber ?? 1, pageSize));
        }

        // GET: Sundays/Details/5
        public async Task<IActionResult> Details(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var sunday = await _context.Sunday
                .Include(s => s.Speakers)
                .FirstOrDefaultAsync(m => m.Id == id);

            if (sunday == null)
            {
                return NotFound();
            }

            return View(sunday);
        }

        // GET: Sundays/Create
        public IActionResult Create()
        {
            return View();
        }

        // POST: Sundays/Create
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Create([Bind("Id,Date,Conductor,OpeningHymn,ClosingHymn,SacramentHymn,IntermediateSong,OpeningPrayer,ClosingPrayer,Theme,Speakers")] Sunday sunday)
        {
            if (ModelState.IsValid)
            {
                _context.Add(sunday);
                await _context.SaveChangesAsync();
                return RedirectToAction(nameof(Index));
            }
            return View(sunday);
        }

        // GET: Sundays/Edit/5
        public async Task<IActionResult> Edit(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var sunday = await _context.Sunday.FindAsync(id);

            if (sunday == null)
            {
                return NotFound();
            }
            return View(sunday);
        }

        // POST: Sundays/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(int id, [Bind("Id,Date,Conductor,OpeningHymn,ClosingHymn,SacramentHymn,IntermediateSong,OpeningPrayer,ClosingPrayer,Theme")] Sunday sunday)
        {
            if (id != sunday.Id)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
                    _context.Update(sunday);
                    await _context.SaveChangesAsync();
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!SundayExists(sunday.Id))
                    {
                        return NotFound();
                    }
                    else
                    {
                        throw;
                    }
                }
                return RedirectToAction(nameof(Index));
            }
            return View(sunday);
        }

        // GET: Sundays/Delete/5
        public async Task<IActionResult> Delete(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var sunday = await _context.Sunday
                .FirstOrDefaultAsync(m => m.Id == id);
            if (sunday == null)
            {
                return NotFound();
            }

            return View(sunday);
        }

        // POST: Sundays/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(int id)
        {
            var sunday = await _context.Sunday.FindAsync(id);
            _context.Sunday.Remove(sunday);
            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }

        private bool SundayExists(int id)
        {
            return _context.Sunday.Any(e => e.Id == id);
        }
    }
}
