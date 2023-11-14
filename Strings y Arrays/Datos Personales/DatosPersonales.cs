namespace Datos_Personales
{
    internal class DatosPersonales
    {
        static void Main(string[] args)
        {
            /* Aproach One */
            string name = "Matelat Borneo, César Osvaldo";
            string invert = "";
            int position = 16;

            Console.WriteLine("Este Programa Cambia de Posición de los Apellidos y Nombres de la Cadena name que contiene Matelat Borneo, César Osvaldo.");
            for (int i = 0; i < name.Length - 2; i++)
            {
                invert += name[position];
                if (position == name.Length - 1)
                {
                    invert += " ";
                }
                if (position == 13)
                {
                    invert = invert + ".";
                }
                position = (position + 1) % name.Length;
            }
            Console.WriteLine("La Nueva Cadena Contiene: {0}", invert);

            /* Aproach Two
            string name = "Matelat Borneo, César Osvaldo";
            Console.WriteLine("Este Programa Cambia de Posición de los Apellidos y Nombres de la Cadena name que contiene Matelat Borneo, César Osvaldo.");
            string[] result = name.Split(' ');
            string[] last = result[1].Split(",");
            Console.WriteLine("La Nueva Cadena es un Array de Cadenas y cada Array Contiene un Dato: {0} {1} {2} {3}.", result[2], result[3], result[0], last[0]); */
        }
    }
}