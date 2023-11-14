namespace Letra_en_Palabra
{
    internal class CharInString
    {
        static void Main(string[] args)
        {
            string cadena;
            char caracter;
            int size;
            int contador = 0;
            char seguir = 's';

            while (seguir == 's')
            {
                Console.WriteLine("Este Programa Cuenta las Letras que se Repiten en una Cadena Introducida por Teclado.\n");
                Console.Write("Ingresa una Palabra: ");
                cadena = Console.ReadLine();
                size = cadena.Length;
                Console.Write("Introduce la Letra a Buscar: ");
                caracter = Console.ReadLine()[0];
                for (int i = 0; i < size; i++)
                {
                    if (cadena[i] == caracter)
                    {
                        contador++;
                    }
                }
                Console.WriteLine("En la Palabra: {0}, el Caracter '{1}' se Repite: {2} Veces.\n", cadena, caracter, contador);
                Console.WriteLine("Presiona la Tecla s Para Introducir Otra Palabra, Cuanlquier otra Tecla Para Salir.");
                seguir = Console.ReadKey().KeyChar;
                Console.Clear();
                contador = 0;
            }
            Console.WriteLine("Presiona Cualquier Tecla Para Salir.");
            Console.ReadKey();
        }
    }
}