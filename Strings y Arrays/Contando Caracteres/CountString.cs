namespace Contando_Caracteres
{
    internal class CountString
    {
        static void Main(string[] args)
        {
            string cadena;
            char seguir = 's';

            while (seguir == 's')
            {
                Console.WriteLine("Este Programa Cuenta los Caracteres que Contiene una Cadena Introducida por Teclado.\n");
                Console.Write("Ingresa una Palabra: ");
                cadena = Console.ReadLine();
                Console.WriteLine("La Palabra: {0}, Tiene: {1} Caracteres.\n", cadena, cadena.Length);
                Console.WriteLine("Presiona la Tecla s Para Introducir Otra Palabra, Cuanlquier otra Tecla Para Salir.");
                seguir = Console.ReadKey().KeyChar;
                Console.Clear();
            }
            Console.WriteLine("Presiona Cualquier Tecla Para Salir.");
            Console.ReadKey();
        }
    }
}