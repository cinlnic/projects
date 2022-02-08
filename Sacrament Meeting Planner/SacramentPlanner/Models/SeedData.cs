using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.DependencyInjection;
using SacramentPlanner.Models;
using System;
using System.Linq;

namespace SacramentMeeting.Models
{
    public static class SeedData
    {
        public static void Initialize(IServiceProvider serviceProvider)
        {
            using (var context = new SacramentPlannerContext(
                serviceProvider.GetRequiredService<
                    DbContextOptions<SacramentPlannerContext>>()))
            {
                
                if (context.Sunday.Any())
                {
                    return;   // DB has been seeded
                }



                int dayOfWeek = (int)DateTime.Now.DayOfWeek;
                DateTime nextSunday = DateTime.Now.AddDays(7 - dayOfWeek).Date;
                DateTime nextNextSunday = DateTime.Now.AddDays(14 - dayOfWeek).Date;
                DateTime nextNextNextSunday = DateTime.Now.AddDays(21 - dayOfWeek).Date;


                context.Sunday.AddRange(
                    new Sunday
                    {
                        Date = nextSunday,
                        Conductor = "Bishop Nielson",
                        OpeningHymn = 26,
                        ClosingHymn = 241,
                        SacramentHymn = 185,
                        IntermediateSong = "Sister Norwood",
                        OpeningPrayer = "Brother Smith",
                        ClosingPrayer = "Brother Robertson",
                        Theme = "Prayer"
                    },

                    new Sunday
                    {
                        Date = nextNextSunday,
                        Conductor = "Bishop Nielson",
                        OpeningHymn = 2,
                        ClosingHymn = 278,
                        SacramentHymn = 187,
                        IntermediateSong = "Brother James",
                        OpeningPrayer = "Sister Stricker",
                        ClosingPrayer = "Sister Wolfe",
                        Theme = "Faith"
                    },

                    new Sunday
                    {
                        Date = nextNextNextSunday,
                        Conductor = "Bishop Nielson",
                        OpeningHymn = 3,
                        ClosingHymn = 279,
                        SacramentHymn = 188,
                        IntermediateSong = "Brother Jackson",
                        OpeningPrayer = "Sister Benny",
                        ClosingPrayer = "Brother Benny",
                        Theme = "Hope"
                    }
                );

               /* 
                context.Speaker.AddRange(
                    new Speaker
                    {
                        
                        Name = "Brother Samewise",
                        Subject = "Faith",
                    },

                    new Speaker
                    {
    
                        Name = "Brother Gamchie",
                        Subject = "Prayer",
                    }
                );
               */
                

                context.SaveChanges();
            }
        }
    }
}